<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Bid extends ActiveRecord
{
    public static function tableName()
    {
        return 't_house_bid';
    }
    
    public static function getBid($id){
    		return static::findOne(['id' => $id,'bidtype'=>0]);
    }
    // 投标年代
    // public static function GetBidByRequirement($requirementid){
    // 		$sql='SELECT  t_house_bid.*,t_user.nickname,t_user.picture,t_house.districtname,t_house.roomcnt,t_house.hallcnt,t_house.bathroomcnt, t_bidcnt.bidtotalcnt,t_bidcnt.bidconfirmcnt,t_house.expectsaleprice,t_house.buildingarea,t_house.buildingarea,t_house.expectsaleprice FROM t_house_bid JOIN t_user ON t_user.id=t_house_bid.biduserid JOIN t_house ON t_house.houseid=t_house_bid.houseid JOIN (SELECT houseid,COUNT(requirementid) AS bidtotalcnt,COUNT( CASE WHEN `bidstatus` =2 THEN 1 ELSE NULL END ) bidconfirmcnt FROM t_house_bid WHERE requirementid='.$requirementid.' GROUP BY houseid) AS t_bidcnt ON t_bidcnt.houseid=t_house_bid.houseid WHERE requirementid='.$requirementid.' and t_house.validflag=1';
    //             Yii::error("sql is ".$sql."\n");
    // 		return static::findBySql($sql)->asArray()->all();
    // }
    //投人年代
    public static function GetBidByRequirement($requirementid,$bool,$city){

        if(empty($city))
        {
             $find = static::find()->select('biduserid')->distinct()->addSelect('t_user.*,t_house_bid.biddate')->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['requirementid'=>$requirementid,'bidtype'=>1])->asArray()->orderBy(['t_house_bid.id'=>SORT_DESC]);
             $count = static::find()->select('biduserid')->distinct()->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['requirementid'=>$requirementid,'bidtype'=>1])->count();
        }
        else
        {
             $find = static::find()->select('biduserid')->distinct()->addSelect('t_user.*,t_house_bid.biddate')->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['requirementid'=>$requirementid,'bidtype'=>1,'t_house_bid.city'=>$city])->asArray()->orderBy(['t_house_bid.id'=>SORT_DESC]);
             $count = static::find()->select('biduserid')->distinct()->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['requirementid'=>$requirementid,'bidtype'=>1,'t_house_bid.city'=>$city])->count();
        }
       
        //if($bool){
        //    $result= $find->limit(6)->all();
        //}else{
            $result= $find->all();
        //}
        
        $res['data'] = $result;
        $res['count'] = $count;
        return $res;
    }

    public static function GetBidByHouse($houseid,$bool){
        $find = static::find()->select('biduserid')->distinct()->addSelect('t_user.*,t_house_bid.biddate')->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['houseid'=>$houseid,'bidtype'=>2])->asArray()->orderBy(['t_house_bid.id'=>SORT_DESC]);
        if($bool){
            $result= $find->limit(6)->all();
        }else{
            $result= $find->all();
        }
        
        $count = static::find()->distinct()->leftjoin('t_user','t_house_bid.biduserid = t_user.id')->where(['houseid'=>$houseid,'bidtype'=>2])->count();
        $res['data'] = $result;
        $res['count'] = $count;
        return $res;
    }

    public static  function modifyBidStatus($jsonObj){
    		try{
    				$bid=static::getBid($jsonObj->bidid);
    				if(empty($bid)){
    						$arr['rscode']=1;
				    		$arr['error']='没找到对应记录';
				    		return $arr;
    				}
    				$bid->bidstatus=$jsonObj->oprtype;
                    $bid->refusereason=$jsonObj->refusereason;
    				$bid->save();
    				$arr['rscode']=0;
		      	return $arr;
				} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				}
    }


    public static  function getSpecificHouseBidInfo($jsonObj){
        //查找 t_house_bid, t_requirement, t_user表
            try{
                    $bid_info = Bid::find()->where(['houseid' => $jsonObj->houseid])->orderBy('biduserid')->asArray()->all();
                    Yii::trace("bid_info is ".print_r($bid_info,1)."\n");
                    $bid_info_count=count($bid_info);
                    if($bid_info_count<1){
                        $arr[0]=false;
                        $arr[1]="no houseid in t_house_bid";
                        return $arr;
                    }

                    Yii::trace("bid_info_count is ".$bid_info_count."\n");

                    for($i=0;$i<$bid_info_count;$i++){

                        Yii::trace("i is ".$i."\n");

                        $requirementid = $bid_info[$i][requirementid];
                        $bidid = $bid_info[$i][id];
                        $bidstatus = $bid_info[$i][bidstatus];
                        $biddate = $bid_info[$i][biddate];

                        $sql = sprintf("SELECT * FROM t_requirement where id=%s ", $requirementid);
                        Yii::trace("sql is ".$sql."\n");
                        $connection = Yii::$app->db;
                        $command = $connection->createCommand($sql);
                        $requirement = $command->queryAll();
                        $requirement_count=count($requirement);
                        if($requirement_count<1){
                            $arr[0]=false;
                            $arr[1]="no requirementid in t_requirement";
                            return $arr;
                        }
                        Yii::trace("requirement is ".print_r($requirement,1)."\n");
                        $requirement_count = count($requirement);
                        $userid = $requirement[0][publishuserid];
                        $requirementtype = $requirement[0][requirementtype];
                        $districtname = $requirement[0][districtname];
                        $housetype = $requirement[0][housetype];
                        $region2 = $requirement[0][region2];
                        $region3 = $requirement[0][region3];
                        // if(1==$requirementtype){//按区域
                        //     $subject = "求购".$region2.$region3.$housetype;   
                        // }elseif (2==$requirementtype) {//按小区
                        //     $subject = "求购".$districtname.$housetype;
                        // }
                        $subject = $requirement[0][subject];
                        $price = $requirement[0][budget];
                        $agentfee = $requirement[0][agentfee];

                        $sql = sprintf("SELECT * FROM t_user where id=%s ", $userid);
                        Yii::trace("sql is ".$sql."\n");
                        $connection = Yii::$app->db;
                        $command = $connection->createCommand($sql);
                        $user = $command->queryAll();
                        Yii::trace("user is ".print_r($user,1)."\n");
                        $user_count = count($user);
                        if($user_count<1){
                            $arr[0]=false;
                            $arr[1]="no id in t_user";
                            return $arr;
                        }
                        $userpicture = $user[0][picture];
                        $nickname = $user[0][nickname];

                        $res[$i]=array(
                            "requirementid"=>$requirementid,
                            "bidid"=>$bidid,
                            "bidstatus"=>$bidstatus,
                            "biddate"=>$biddate,
                            "userid"=>$userid,
                            "housetype"=>$housetype,
                            "subject"=>$subject,
                            "price"=>$price,
                            "agentfee"=>$agentfee,
                            "userpicture"=>$userpicture,
                            "nickname"=>$nickname
                        );
                    }

                    return $res;
                } catch(\Exception $e) {
                    Yii::error("Bid::getSpecificHouseBidInfo error is ".$e->getMessage()."\n");
                    return $e->getMessage();
                }
    }

/*投标年代
    public static  function DoBid($jsonObj){
            try{
                    $sql = sprintf("SELECT * FROM t_requirement where id=%s ", $jsonObj->requirementid);
                    Yii::trace("sql is ".$sql."\n");
                    $connection = Yii::$app->db;
                    $command = $connection->createCommand($sql);
                    $requirement = $command->queryAll();
                    Yii::trace("requirement is ".print_r($requirement,1)."\n");
                    $requirement_count = count($requirement);
                    if($requirement_count<1){
                        return 2;
                    }
                    $requirementuserid = $requirement[0][publishuserid];
                    Yii::trace("requirement[0] is ".print_r($requirement[0],1)."\n");
                    Yii::trace("requirementuserid is ".$requirementuserid."\n");

                    $sql = sprintf("SELECT * FROM t_user where id=%s ", $jsonObj->biduserid);
                    Yii::trace("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    Yii::trace("user is ".print_r($user,1)."\n");
                    $user_count = count($user);
                    if($user_count<1){
                        return 3;
                    }
                    
                    for($i=0;$i<count($jsonObj->houseids);$i++){

                        Yii::trace("houseids are ".print_r($jsonObj->houseids,1)."\n");
                        Yii::trace("houseids[$i] is ".print_r($jsonObj->houseids[$i],1)."\n");

                        $sql = sprintf("SELECT * FROM t_house where houseid=%s", $jsonObj->houseids[$i]->houseid);
                        Yii::trace("sql is ".$sql."\n");
                        $command = $connection->createCommand($sql);
                        $house_supplement = $command->queryAll();
                        $houseid_count = count($house_supplement);
                        if($houseid_count<1){
                            $arr[0]=4;
                            $arr[1]=$jsonObj->houseids[$i]->houseid;
                            return $arr;
                        }

                        $sql = sprintf("SELECT * FROM t_house_bid where houseid=%s and requirementid=%s", $jsonObj->houseids[$i]->houseid, $jsonObj->requirementid);
                        Yii::trace("sql is ".$sql."\n");
                        $command = $connection->createCommand($sql);
                        $house_bid = $command->queryAll();
                        $house_bid_count = count($house_bid);
                        if($house_bid_count>0){
                            return 5;
                        }

                        $bid = new Bid();
                        $bid->biduserid = $jsonObj->biduserid;
                        $bid->requirementuserid = $requirementuserid;
                        $bid->requirementid = $jsonObj->requirementid;
                        $bid->bidstatus = 1;
                        $bid->bidtype = 0;//暂时填写0，具体什么值到时候再说
                        $bid->biddate = date("Y-m-d_H:i:s");
                        $bid->houseid = $jsonObj->houseids[$i]->houseid;

                        $bid->save();
                    }

                    return 0;
                } catch(\Exception $e) {
                    Yii::error("Bid::DoBid error is ".$e->getMessage()."\n");
                    $arr[0]=1;
                    $arr[1]=$e->getMessage();
                    return $arr;
                }
    }
*/
//匹配年代
    public static  function DoBid($jsonObj){
        if($data = Bid::find()->where(['requirementid'=>$jsonObj->rentid,'biduserid'=>$jsonObj->biduserid,'bidtype'=>$jsonObj->bidtype,'city'=>$jsonObj->city])->one()){
                $data->biddate = date('Y-m-d H:i:s',time());
                if($data->save()){
                    return ['rscode'=>0,'bid'=>$data->id];
                }else{
                    return ['rscode'=>1];
                }
            }else{
                $model = new \frontend\models\Bid();
                $model->requirementid =   $jsonObj->requirementid;
                $model->requirementuserid =   $jsonObj->requirementuserid;
                $model->biduserid     =   $jsonObj->biduserid;
                $model->bidtype       =   $jsonObj->bidtype;
                $model->bidstatus     =   4;
                $model->biddate       =   date('Y-m-d H:i:s',time());
                $model->validflag     =   1;
                $model->houseid       =   $jsonObj->houseid;
                if(isset($jsonObj->city) && !empty($jsonObj->city))
                {
                    $model->city = $jsonObj->city;
                }

                if($model->save()){
                    return ['rscode'=>0];
                }else{
                    return ['rscode'=>1];
                }
            }
    }



    public static  function BidStatus(){
        echo "modify BidStatus\n";

        $bids=static::find()->where(['validflag'=>1,'bidstatus'=>1])->all();
        echo "bids are ".print_r($bids,1)."\n";

        foreach ($bids as $bid) {
            $biddate=strtotime($bid->biddate);
            $timenow=strtotime(date("Y-m-d H:i:s"));
            $timespan=$timenow-$biddate;
            $timespan=round($timespan/3600);
            echo "timespan is ".$timespan."\n";
            if($timespan>48){
                echo "bid is ".print_r($bid,1)."\n";
                $bid->bidstatus=4;
                $bid->save();
            }
        }
    }

}

?>

<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;


class Supplyment extends ActiveRecord
{
	public static function tableName()
    {
        return 't_house'.CITY;
    }
	
 
    public static function SubmitHouse($jsonObj)
    {
    	try{

			$house = new Supplyment();
			$session = Yii::$app->session;
			$mid = $session->get('msgid');
			if($jsonObj->mid == $mid){
				return ['code'=>1];
			}else{
				$mid = $session->set('msgid',$jsonobj->mid);
			}
			$house->userid = $jsonObj->userid;
			$house->districtid = $jsonObj->districtid;
			$house->districtname = $jsonObj->districtname;
			$house->housenumber = $jsonObj->housenumber;
			$house->roomnumber = $jsonObj->roomnumber;
			$house->buildingarea = $jsonObj->buildingarea;
			$house->expectsaleprice = $jsonObj->expectsaleprice;
			$house->storey = $jsonObj->storey;
			$house->totalstorey = $jsonObj->totalstorey;
			$house->roomcnt = $jsonObj->roomcnt;
			$house->hallcnt = $jsonObj->hallcnt;
			$house->bathroomcnt = $jsonObj->bathroomcnt;
			$house->houseage = $jsonObj->houseage;
			$house->buildingtype = $jsonObj->buildingtype;
			$house->decorationtype = $jsonObj->decorationtype;
			$house->orientation = $jsonObj->orientation;
			$house->detail = $jsonObj->detail;
			$house->schooldistrictflag = $jsonObj->schooldistrictflag;
			$house->metroflag = $jsonObj->metroflag;
			$house->owneronlyflag = $jsonObj->owneronlyflag;
			$house->overfiveonlyflag = $jsonObj->overfiveonlyflag;
			$house->publishdate = date("Y-m-d_H:i:s");
			$house->city = $jsonObj->city;
	        $house->save();
	        return ['code'=>0,'houseid'=>$house->houseid];
        } catch(\Exception $e) {
        	Yii::error("Supplyment::SubmitHouse error is ".$e->getMessage()."\n");
            return ['code'=>1];
        }
        
    }


	public static function ModifyHouse($jsonObj)
	{
		
		try{
			
			$connection = Yii::$app->db;
			$sql = sprintf('UPDATE t_house'.CITY.' SET userid = %s, districtid = %s, districtname = %s, housenumber = %s, roomnumber = %s, buildingarea = %s, expectsaleprice = %s, storey = %s, totalstorey = %s, roomcnt = %s, hallcnt = %s, bathroomcnt = %s, houseage = %s, buildingtype = %s, decorationtype = %s, orientation = %s, detail = %s, schooldistrictflag = %s, metroflag = %s, owneronlyflag = %s, overfiveonlyflag = %s where houseid=%s and validflag=1', $jsonObj->userid, $jsonObj->districtid, "\"".$jsonObj->districtname."\"", $jsonObj->housenumber, $jsonObj->roomnumber, $jsonObj->buildingarea, $jsonObj->expectsaleprice, $jsonObj->storey, $jsonObj->totalstorey, $jsonObj->roomcnt, $jsonObj->hallcnt, $jsonObj->bathroomcnt, $jsonObj->houseage, "\"".$jsonObj->buildingtype."\"", "\"".$jsonObj->decorationtype."\"", "\"".$jsonObj->orientation."\"", "\"".$jsonObj->detail."\"", $jsonObj->schooldistrictflag, $jsonObj->metroflag, $jsonObj->owneronlyflag, $jsonObj->overfiveonlyflag, $jsonObj->houseid);


			Yii::error("ModifyHouse sql is ".$sql."\n");
			$command = $connection->createCommand($sql);
			$houseid = $command->execute();
			$arr['rscode']=0;
			return $arr;
		} catch(\Exception $e) {
			Yii::error("Supplyment::ModifyHouse error is ".$e->getMessage()."\n");
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
            return $arr;
        }
	}


	public static function GetMyHouse($jsonObj)
	{
		try{
			$res = static::find()->where(['userid' => $jsonObj->userid, 'validflag' => 1])->orderBy('houseid')->asArray()->all();
			Yii::error("res is ".print_r($res,1)."\n");
			return $res;
		} catch(\Exception $e) {
			Yii::error("Supplyment::GetMyHouse error is ".$e->getMessage()."\n");
            return $e->getMessage();
        }
	}


	public static function GetHouseDetail($jsonObj)
	{
		try{
			$res = Supplyment::find()->where(['houseid' => $jsonObj->houseid, 'validflag' => 1])->orderBy('userid')->asArray()->all();
			//$res = static::find()->where(['houseid'=>$jsonObj->houseid, 'validflag'=>1])->one();

			Yii::error("res is ".print_r($res,1)."\n");

			return $res;
		} catch(\Exception $e) {
			Yii::error("Supplyment::GetHouseDetail error is ".$e->getMessage()."\n");
            return $e->getMessage();
        }
	}


	public static function DelHouseByHouseid($jsonObj)
	{
		try{
			$house = static::find()->where(['houseid' => $jsonObj->houseid, 'validflag'=>1])->one();
			Yii::trace("Houseid is ".print_r($jsonObj,1)."\n");
			if($house==null){
				Yii::error("Houseid not exist\n");
				$res['rscode']=1;
				$res['error']='houseid not exist';
	            return $res;
			}
			$house->validflag=0;
			$house->save();
			$res['rscode']=0;
			return $res;
		} catch(\Exception $e) {
			Yii::error("Supplyment::DelHouseByHouseid error is ".$e->getMessage()."\n");
			$res['rscode']=1;
			$res['error']=$e->getMessage();
            return $res;
        }
	}


	public static function GetMatchHouseList($jsonObj)
	//有限的房源与需求的匹配
	{
		try{
			//查4张表 t_requirement, t_user, t_house, t_house_bid
        
	        $sql = sprintf("SELECT * FROM t_user where id=%s and validflag=1", $jsonObj->supplyuserid);
	        Yii::trace("sql is ".$sql."\n");

	        $connection = Yii::$app->db;
	        $command = $connection->createCommand($sql);
	        $user = $command->queryAll();
	        Yii::trace("user is ".print_r($user,1)."\n");
	        $user_count = count($user);
	        $userpicture = $user[0][picture];
	        $nickname = $user[0][nickname];
	        Yii::trace("userpicture is ".$userpicture."\n");
	        Yii::trace("nickname is ".$nickname."\n");


	        $sql = sprintf("SELECT * FROM t_requirement".CITY." where id=%s and validflag=1", $jsonObj->requirementid);
	        Yii::trace("sql is ".$sql."\n");

	        $connection = Yii::$app->db;
	        $command = $connection->createCommand($sql);
	        $requirement = $command->queryAll();
	        Yii::trace("requirement is ".print_r($requirement,1)."\n");
	        $requirement_count = count($requirement);

	        $requirementtype = $requirement[0][requirementtype];
	        Yii::trace("requirementtype is ".$requirementtype."\n");
	        $districtname = $requirement[0][districtname];
	        Yii::trace("districtname is ".$districtname."\n");
	        $region2 = $requirement[0][region2];
	        Yii::trace("region2 is ".$region2."\n");
	        $region3 = $requirement[0][region3];
	        Yii::trace("region3 is ".$region3."\n");
	        $housetype = $requirement[0][housetype];
	        Yii::trace("housetype is ".$housetype."\n");
	        if(1==$requirementtype){
	        	$subject = "求购".$region2.$region3.$housetype;	
	        }elseif (2==$requirementtype) {
	        	$subject = "求购".$districtname.$housetype;
	        }
	        
	        Yii::trace("subject is ".$subject."\n");
	        $price = $requirement[0][budget];
	        Yii::trace("price is ".$price."\n");
	        $agentfee = $requirement[0][agentfee];
	        Yii::trace("agentfee is ".$agentfee."\n");
	        $publishdate = $requirement[0][updatetime];
	        Yii::trace("publishdate is ".$publishdate."\n");

	        $sql = sprintf("SELECT * FROM t_house".CITY." where userid=%s and validflag=1", $jsonObj->supplyuserid);
	        Yii::trace("sql is ".$sql."\n");

	        $connection = Yii::$app->db;
	        $command = $connection->createCommand($sql);
	        $house = $command->queryAll();
	        Yii::trace("house is ".print_r($house,1)."\n");
	        $house_count = count($house);
	        for($i=0;$i<$house_count;$i++){

		        $houseid = $house[$i][houseid];
		        $instance = new Supplyment();
		        $matchrate = $instance->getMark($requirement[0],$house[$i]);
		        $sql = sprintf("SELECT * FROM t_house_bid where houseid=%s and requirementid=%s and validflag=1", $houseid, $jsonObj->requirementid);
		        Yii::trace("sql is ".$sql."\n");

		        $connection = Yii::$app->db;
		        $command = $connection->createCommand($sql);
		        $bid_info = $command->queryAll();
		        Yii::trace("bid_info is ".print_r($bid_info,1)."\n");
		        $bid_info_count = count($bid_info);
		        if($bid_info_count<1){
		        	$status = 0;
		        }else{
		        	$status = $bid_info[$i][bidstatus];
		        }

		        $my_house_inifo[$i] = array(
		        	"houseid"=>$houseid,
		        	"userid"=>$jsonObj->supplyuserid,
		        	"districtid"=>$house[$i][districtid],
		        	"districtname"=>$house[$i][districtname],
		        	"buildingarea"=>$house[$i][buildingarea],
		        	"expectsaleprice"=>$house[$i][expectsaleprice],
		        	"roomcnt"=>$house[$i][roomcnt],
		        	"hallcnt"=>$house[$i][hallcnt],
		        	"bathroomcnt"=>$house[$i][bathroomcnt],
		        	"matchrate"=>$matchrate,
		        	"status"=>$status
		        );
	    	}

    		$res=array(
	            "requirementid"=>$jsonObj->requirementid,
	            "userid"=>$jsonObj->supplyuserid,
	            "userpicture"=>$userpicture,
	            "nickname"=>$nickname,
	            "subject"=>$subject,
	            "price"=>$price,
	            "housetype"=>$housetype,
	            "agentfee"=>$agentfee,
	            "publishdate"=>$publishdate,
	            "house"=>$my_house_inifo,
	        );

	        return json_encode($res);

		} catch(\Exception $e) {
			Yii::error("Supplyment::GetMatchHouseList error is ".$e->getMessage()."\n");
            return $e->getMessage();
        }
	}


	public static function tRecommend($jsonObj)
	{
		//单需求找房源匹配
		try{
			$requirementId = $jsonObj->requirementid;
			$rdata = \frontend\models\requirement::findOne($requirementId);
			$where['t_house.validflag'] = 1;
			$where['t_user.validflag'] = 1;
			//30天内
			$before = time()-2592000;  
			//房屋类型
			$where['t_house.buildingtype'] = $rdata['buildingtype'];
			//户型
			$where['roomcnt'] = $rdata['housetype'];
			$model = (new \yii\db\Query())->select('t_house.*,t_user.nickname,t_user.picture')->from('t_house')->leftjoin('t_user','t_user.id = t_house.userid')->where($where)->orderBy(['houseid'=>SORT_DESC])->limit(10)->offset(0);
			//requirementtype
			if($rdata->requirementtype == 1){  //按区域发布
				    	$region = str_split($rdata['region1'],2);
			    		//判断区域 地铁 学区 的匹配
			    		switch ($region[0]) {
			    			case '12': //school
			    				$subQuery = (new \yii\db\Query())->select('districtids')->from('t_school_district')->where(['region'=>$region[1],'schoolid'=>$region[2]]);
			    				if($rdata['region2']){
			    					$region2 = str_split($rdata['region2'],2);
			    					$subQuery -> orwhere(['region'=>$region2[1],'schoolid'=>$region2[2]]);
			    				}
			    				if($rdata['region3']){
			    					$region3 = str_split($rdata['region3'],2);
			    					$subQuery -> orwhere(['region'=>$region3[1],'schoolid'=>$region3[2]]);
			    				}
			    				break;
			    			case '13': //area
			    				$regions = $jsonObj->regions;
								if(strlen($regions) > 6){
									$exp = explode(',', $regions);
									foreach ($exp as $value) {
										$region[]= substr($value, 2,2);
									}
								}else{
									$region[] = substr($regions, 2,2);
								}
			    				$subQuery = (new \yii\db\Query())->select('districtid')->from('t_residential_district')->where(['in','region',$region]);

			    				break;
			    			case '11': //metro
			    				$metro = \common\helpers\Area::getArea($region[0],$region[1],$region[2]);
			    				$distance = \common\helpers\Functions::getRange($metro['longitude'],$metro['latitude'],3000);
			    				$subQuery = (new \yii\db\Query())->select('districtid')->from('t_residential_district')->where('longitude BETWEEN '.$array['minLon'].' and '.$array['maxLon'].') and (latitude BETWEEN '.$array['minLat'].' and '.$array['maxLat']);
			    				if($rdata['region2']){
			    					$region2 = str_split($rdata['region2'],2);
			    					$metro = \common\helpers\Area::getArea($region2[0],$region2[1],$region2[2]);
			    					$distance = \common\helpers\Functions::getRange($metro['longitude'],$metro['latitude'],3000);
			    					$subQuery ->orwhere('longitude BETWEEN '.$array['minLon'].' and '.$array['maxLon'].') and (latitude BETWEEN '.$array['minLat'].' and '.$array['maxLat']);
			    				}
			    				if($rdata['region3']){
			    					$region3 = str_split($rdata['region3'],2);
			    					$metro = \common\helpers\Area::getArea($region3[0],$region3[1],$region3[2]);
			    					$distance = \common\helpers\Functions::getRange($metro['longitude'],$metro['latitude'],3000);
			    					$subQuery ->orwhere('longitude BETWEEN '.$array['minLon'].' and '.$array['maxLon'].') and (latitude BETWEEN '.$array['minLat'].' and '.$array['maxLat']);
			    				}
			    				break;	    				
			    		}
		    	$model->andwhere(['in', 'districtid', $subQuery]);
			}else{  //按小区发布
				$model->andwhere(['districtid'=>$rdata['districtid']]);
			}

			
			//判断价格
			$price = explode('-', $rdata['budget']);
			// var_dump($price);
			$model->andwhere(['BETWEEN','expectsaleprice',$price[0],$price[1]]);

			//判断楼层
			$storey = explode('-', $rdata['storey']);
			$model->andwhere(['BETWEEN','storey',$storey[0],$storey[1]]);

			//时间范围
			$model->andwhere(['BETWEEN','t_house.publishdate',date('Y-m-d h:i:s',$before),date('Y-m-d h:i:s',time())]);
			$model->andwhere(['<>', 'userid', $jsonObj->userid]);
			
			$result = $model->all();
			return $result;
		} catch(\Exception $e) {
			Yii::error("Supplyment::GetSystemRecommend error is ".$e->getMessage()."\n");
            return $e->getMessage();
        }
	}


	public static function GetSystemRecommend($jsonObj)
		{
			//房源找需求匹配
			try{
				$regions = $jsonObj->regions;
				$requirementId = $jsonObj->requirementid;
				$rdata = \frontend\models\Requirement::findOne($requirementId);
				if(strlen($regions) > 6){
					$exp = explode(',', $regions);
					foreach ($exp as $value) {
						$region.= ','.substr($value, 2,2);
					}
					$region = substr($region , 1);
				}else{
					$region = substr($regions, 2,2);
				}
				
				$connection = Yii::$app->db;
				$sql = sprintf("select t_house.*,t_user.nickname,t_user.picture from t_house LEFT JOIN t_user on t_user.id = t_house.userid where districtid in (select districtid from t_residential_district where region in (%s) ) and t_house.validflag = 1 and t_user.validflag =1 and userid != %s order by houseid desc limit 60;", $region , $jsonObj->userid);
				$command = $connection->createCommand($sql);
				$result = $command->queryAll();
				$suppy = new self();
				foreach ($result as $i => $value) {
					// var_dump($value['districtid']);
					$res[$i] = $value;
					$res[$i]['mark'] = $suppy->getMark($rdata->attributes,$value);
				}
				$cnt = count($res);
			    for ($i = 0; $i < $cnt; $i++) {
			        for ($j = 0; $j < $cnt - $i - 1; $j++) {
			            if ($res[$j]['mark'] < $res[$j + 1]['mark']) {
			                $temp = $res[$j];
			                $res[$j] = $res[$j + 1];
			                $res[$j + 1] = $temp;
			            }
			        }
			    }
				return $res;
			} catch(\Exception $e) {
				Yii::error("Supplyment::GetSystemRecommend error is ".$e->getMessage()."\n");
	            return $e->getMessage();
	        }
		}
	
    public function getMark($requirement,$house){
    	$sql = sprintf("SELECT region,plate,latitude,longitude FROM t_residential_district where districtid=%s", $house['districtid']);
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql);
		$district = $command->queryAll();
		// var_dump($district);
		if(!$requirement['districtid']){
	    	$requirementAreas = [$requirement['region1'],$requirement['region2'],$requirement['region3']];
	    	foreach ($requirementAreas as $requirementArea) {
	    		if ($requirementArea) {
		    		$marks = 100;
		    		$less = 0;
		    		$region = str_split($requirementArea,2);
		    		//1. 判断房屋类型
		    		if ($requirement['buildingtype'] != $house['buildingtype']){
		    			$marks-=40;
		    		}
		    		yii::error($requirement['buildingtype']);
		    		yii::error($house['buildingtype']);
		    		yii::error($requirement['buildingtype'] != $house['buildingtype']);
		    		yii::error($marks."<-类型判断\n");
		    		//2. 判断区域 地铁 学区 的匹配
		    		switch ($region[0]) {
		    			case '12': //school
		    				$district_school = $connection->createCommand(sprintf("SELECT region,schoolid FROM t_district_school where districtid =%s",$house['districtid']))->queryAll();
		    				foreach ($district_school as $dskey => $dsvalue) {
		    					if($region[1] == $dsvalue[$dskey]['region'] && $region[2] == $dsvalue[$dskey]['schoolid']){
		    					}else{
		    						$marks-=50;
		    					}
		    				}
		    				break;
		    			case '13': //area
		    				if($district[0]['region'].$district[0]['plate'] == $region[1].$region[2]){

		    				}else{
		    					$marks-=50;
		    				}
		    				yii::error($district[0]['region'].$district[0]['plate'] == $region[1].$region[2]);
		    				break;
		    			case '11': //metro
		    				$metro = \common\helpers\Area::getArea($region[0],$region[1],$region[2]);
		    				$distance = \common\helpers\Functions::getDistance3($metro['longitude'],$metro['latitude'],$district[0]['longitude'],$district[0]['latitude']);
		    				if($distance <= 1000){
		    				}else{
		    					$less=ceil(($distance-1000)/200)*5;
		    				}
		    				$less=($less>50)?'50':$less;
		    				$marks-=$less;
		    				break;	    				
		    		}
		    	
			    	yii::error($marks."<-区域判断\n");

		    		//3. 判断楼层，价格，户型
		    		
		    		$price = explode('-', $requirement['budget']);
		    		if(($house['expectsaleprice'] <= $price[1]) && ($house['expectsaleprice'] >= $price[0])){
		    		}elseif($house['expectsaleprice'] > $price[1]){

		    			$less = ceil(($house['expectsaleprice'] - $price[1])*100/$price[1]);
		    			$less=($less>50)?'50':$less;
		    			$marks -=$less;
		    		}else{
		    			$less = ceil(($price[0] - $house['expectsaleprice'])*100/$price[0]);
		    			$less=($less>50)?'50':$less;
		    			$marks -=$less;
		    		}
		    		yii::error($marks."<-价格判断\n");
		    		$storey = explode('-', $requirement['storey']);
		    		if(($house['storey'] <= $storey[1]) && ($house['storey'] >= $storey[0])){
		    		}elseif($house['storey'] > $storey[1]){
		    			$less = $house['storey'] - $storey[1];
		    			$less=($less>10)?'10':$less;
		    			$marks -=$less;
		    		}else{
		    			$less = $storey[0] - $house['storey'];
		    			$less=($less>10)?'10':$less;
		    			$marks -=$less;
		    		}
		    		yii::error($marks."<-楼层判断\n");

		    		$rhousecnt = intval($requirement['housetype']);
		    		if($house['roomcnt'] == $rhousecnt){
		    		}else{
		    			$less = abs($house['roomcnt'] - $rhousecnt);
		    			$marks -=$less*5;
		    		}
		    		$marks = $marks>0?$marks:0;
		    		$mark[]=$marks;
		    		yii::error($marks."<-户型判断\n");
	    		} //end if
	    	}//end foreach
	    	if(count($mark) > 1){
	    		rsort($mark);
			}
		    yii::error(print_r($marks,1)."<-最终判断\n");

			return $mark[0];
		}else{
	    	if($requirement['districtid']!=$house['districtid']){
	    		$marks=50;
	    	}else{
	    		$marks=100;
	    	}
			// yii::error($marks."<-区域判断\n");

	    	// var_dump($marks);
	    	//3. 判断楼层，价格，户型
	    		
	    	$price = explode('-', $requirement['budget']);
	    	// var_dump($price);
	    	// var_dump($requirement['budget']);
	    	// var_dump($house['expectsaleprice']);
	    	if(($house['expectsaleprice'] <= $price[1]) && ($house['expectsaleprice'] >= $price[0])){
	    	}elseif($house['expectsaleprice'] > $price[1]){
				$less = ceil(($house['expectsaleprice'] - $price[1])*100/$price[1]);
	    		$less=($less>50)?'50':$less;
	    		$marks -=$less;
	    	}else{
	    		$less = ceil(($price[0] - $house['expectsaleprice'])*100/$price[0]);
	    		$less=($less>50)?'50':$less;
	    		$marks -=$less;
	    	}
	    	// yii::error($marks."<-价格判断\n");

	    	// var_dump($marks);
	    	$storey = explode('-', $requirement['storey']);
	    	// var_dump($storey);
	    	// var_dump($house['storey']);
	    	// var_dump(($house['storey'] <= $storey[1]) && ($house['storey'] >= $storey[0]));

	    	if(($house['storey'] <= $storey[1]) && ($house['storey'] >= $storey[0])){
	    		// var_dump("in storey");
	    	}elseif($house['storey'] > $storey[1]){
	    		// var_dump("more storey");
	    		$less = $house['storey'] - $storey[1];
	    		$less=($less>10)?'10':$less;
	    		$marks -=$less;
	    	}else{
	    		// var_dump("less storey");
	    		$less = $storey[0] - $house['storey'];
	    		$less=($less>10)?'10':$less;
	    		$marks -=$less;
	    	}
	    	// yii::error($marks."<-楼层判断\n");

	    	// var_dump("楼层mark:".$marks);
	    	$rhousecnt = intval($requirement['housetype']);
	    	if($house['roomcnt'] == $rhousecnt){
	    	}else{
	    		$less = abs($house['roomcnt'] - $rhousecnt);
	    		$marks -=$less*5;
	    	}

	    	// var_dump("室mark".$marks);
	    	$marks = $marks>0?$marks:0;
	    	// yii::error($marks."<-户型判断\n");

	    	return $marks;
		}	
	}

	public static function GetUserLimit($jsonObj)
	{
		try{
			$user_supply = Supplyment::find()->where(['userid' => $jsonObj->userid, 'validflag' => 1])->orderBy('houseid')->asArray()->all();
			$user_supply_count = count($user_supply);
			Yii::trace("user_supply is ".print_r($user_supply,1)."\n");
			$arr['rscode']=0;
            $arr['user_supply_count']=$user_supply_count;
            return $arr;
		} catch(\Exception $e) {
			Yii::error("Supplyment::GetUserLimit error is ".$e->getMessage()."\n");
			$arr['rscode']=1;
            $arr['error']=$e->getMessage();
            return $arr;
        }
	}


	public static function PushSupplyment($jsonObj){
			$table_n=static::tableName();
			Yii::error("Supplyment::PushSupplyment tableName is ".$table_n);
			Yii::error("Supplyment::PushSupplyment jsonObj is ".print_r($jsonObj,1)."\n");
			//先根据supplymentid获取到房源详情
			$supply = static::find()->where(['houseid'=>$jsonObj->supplymentid, 'validflag'=>1])->one();
			Yii::error("supply is ".print_r($supply,1)."\n");
			
			//增加不向同公司同事推送的逻辑
			//获取发布所属的公司---经纪人
			$publishAgentOrganization = null;
			$publishAgentInfo = Agent::findIdentity($supply->userid);
			if(!empty($publishAgentInfo) && !empty($publishAgentInfo->organization))
			{
				$publishAgentOrganization = $publishAgentInfo->organization;
			}
			
			$regions=null;
			$user=null;
			$content='您的区域有新的房源信息请查看';
			
			//是按照小区发布的，取districtid值，然后到 t_residential_district 表去取 region和plate字段，组成 板块ID。
			$connection = Yii::$app->db;
			$sql='SELECT * FROM t_residential_district'.CITY.' WHERE districtid='.$supply->districtid;
			Yii::error("Supplyment::PushSupplyment sql is $sql\n");
			$command = $connection->createCommand($sql);
    		$residential_district = $command->queryAll();
    		Yii::error("Supplyment::PushSupplyment residential_district is ".print_r($residential_district,1)."\n");
    		$region='13'.$residential_district[0]['region'].$residential_district[0]['plate'];

			$sql='SELECT * FROM v_agent WHERE FIND_IN_SET(\''.PREFIX.$region.'\',activeregion)';
    		
    		if(!empty($publishAgentOrganization) && $publishAgentOrganization != '')
			{
				$sql .= ' and organization not like \'%';
				$sql .= $publishAgentOrganization;
				$sql .= '%\'';
			}
			
    		Yii::error("Supplyment::PushSupplyment sql is $sql\n");
			$command = $connection->createCommand($sql);
    		$users = $command->queryAll();
    		Yii::error("Supplyment::PushSupplyment users are ".print_r($users,1)."\n");
    		//发送模板消息
    		foreach ($users as $user) {
    			static::sendTemplateMessage($user['userid'],$supply->userid,$content,$jsonObj->supplymentid);
    		}
    		
    		$arr['recode']=0;
	    	return $arr;
	}





	static function sendTemplateMessage($userid,$expertid,$content,$supplymentid)
    {
        //$userid是收信人，$expertid是发信人就是需求发布者，$conten是内容，$supplymentid是需求ID
        $template = array();
        $template['data'] = array();

        Yii::error("sendTemplateMessage: userid is $userid, expertid is $expertid, content is $content,
            orderid is $orderid\n");

    	$userid=$userid;
    	$fromNickname='芝麻找房';
    	
        $url='http://www.zmzfang.com/weixin/HomePage/HouseDetail.html?houseId='.$supplymentid.'&userId='.$expertid;
    	Yii::error("case 1: userid is $userid, fromNickname is $fromNickname, url is $url\n");

		$toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
        Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");


        $content = isset($content)?$content:"点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的消息请查收';
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,$fromNickname,date('Y-m-d',time()),$content];
        $col = [];

        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['wxopenid'];
        $template['url']    = $url;
        Yii::error("template is : ".print_r($template,1)."\n");
        
        if(!empty($toUserInfo['wxopenid'])){
            $Wechatmodel = new Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
        }else{
            $res =[];
        }
        
        return $res;
    } 



}


?>

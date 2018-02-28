<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Expert extends ActiveRecord
{
	public static function tableName()
    {
        return 't_expert';
    }

    public static function primaryKey()
    {
            return ['id'];
    }


    public static function addExpert($jsonObj)
    {
    		try{
    				$expert = new Expert();
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
    				$expert->userid=$jsonObj->userid;
					$expert->name=$jsonObj->name;
					$expert->organization=$jsonObj->organization;
                    $expert->workperiod=$jsonObj->workperiod;
                    $expert->position=$jsonObj->position;
                    $expert->email=$jsonObj->email;
                    $expert->activeregion=$jsonObj->activeregion;
                    $expert->businesscard=$jsonObj->businesscard;
                    $expert->headpicture=$jsonObj->headpicture;
                    $expert->introduction=$jsonObj->introduction;
                    $expert->expertisen=$jsonObj->expertisen;
                    $expert->onlinecharge=$jsonObj->onlinecharge;
                    $expert->offlinetime=$jsonObj->offlinetime;
                    $expert->offlinecharge=$jsonObj->offlinecharge;
                    $expert->domain=$jsonObj->domain;
                    $expert->referrer=$jsonObj->referrer;
					$expert->save();
    				$arr['rscode']=0;
                    $arr['expertid']=$expert->attributes['id'];
				    return $arr;
    		} catch(\Exception $e) {
                    Yii::error("Expert::addExpert error is ".$e->getMessage()."\n");
				    return 1;
			} 
    }
    

    public static function modifyExpert($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $expert=static::find()->where(['id' => $jsonObj->expertid])->one();
                    if(empty($expert)){
                            $arr['rscode']=1;
                            $arr['error']='用户不存在';
                            return $arr;    
                    }

                    $expert->userid=$jsonObj->userid;
                    $expert->name=$jsonObj->name;
                    $expert->organization=$jsonObj->organization;
                    $expert->workperiod=$jsonObj->workperiod;
                    $expert->position=$jsonObj->position;
                    $expert->email=$jsonObj->email;
                    $expert->activeregion=$jsonObj->activeregion;
                    $expert->businesscard=$jsonObj->businesscard;
                    $expert->headpicture=$jsonObj->headpicture;
                    $expert->introduction=$jsonObj->introduction;
                    $expert->expertisen=$jsonObj->expertisen;
                    $expert->onlinecharge=$jsonObj->onlinecharge;
                    $expert->offlinetime=$jsonObj->offlinetime;
                    $expert->offlinecharge=$jsonObj->offlinecharge;
                    $expert->domain=$jsonObj->domain;
                    if($expert->status ==2){
                        $expert->status=3;
                    }
                    $expert->save();
                    $arr['rscode']=0;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Expert::ModifyExpert error is ".$e->getMessage()."\n");
                    return 1;
            } 
    }


    public static function getExpert($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $expert=static::find()->where(['id' => $jsonObj->id])->one();
                    if(!$expert){
                            $arr['rscode']=1;
                            $arr['error']='用户不存在';
                            return $arr;    
                    }

                    $arr['expertid']=$expert->id;
                    $arr['expertname']=$expert->name;
                    $arr['expertpicture']=$expert->headpicture;
                    $arr['expertisen']=$expert->expertisen;
                    $arr['praisecnt']=$expert->praisecnt;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Expert::getExpert error is ".$e->getMessage()."\n");
                    return 1;
            } 
    }


    public static function getExpertDetail($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $expert=static::find()->where(['id' => $jsonObj->id])->one();
                    if(empty($expert)){
                            $arr['rscode']=1;
                            $arr['error']='用户不存在';
                            return $arr;
                    }
                    $arr['xsdf'] = \frontend\models\Appointment::find()->where(['status'=>2,'appointmenttype'=>1])->count();
                    $arr['xxdf'] = \frontend\models\Appointment::find()->where(['status'=>6,'appointmenttype'=>1])->count();


                    $arr['praisecnt']=$expert->praisecnt;
                    $arr['userid']=$expert->userid;
                    $arr['name']=$expert->name;
                    $arr['organization']=$expert->organization;
                    $arr['workperiod']=$expert->workperiod;
                    $arr['position']=$expert->position;
                    $arr['email']=$expert->email;
                    $arr['activeregion']=$expert->activeregion;
                    $arr['businesscard']=$expert->businesscard;
                    $arr['headpicture']=$expert->headpicture;
                    $arr['introduction']=$expert->introduction;
                    $arr['expertisen']=$expert->expertisen;
                    $arr['onlinecharge']=$expert->onlinecharge;
                    $arr['offlinetime']=$expert->offlinetime;
                    $arr['offlinecharge']=$expert->offlinecharge;
                    $arr['domain']=$expert->domain;
                    $arr['status']=$expert->status;
                    $arr['reason']=$expert->reason;
                    
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Expert::getExpertDetail error is ".$e->getMessage()."\n");
                    // var_dump($e->getMessage());
                    return 1;
            } 
    }


    public static function getExpertList($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $connection = Yii::$app->db;
                    if('%'==$jsonObj->domain){
                        $sql = sprintf("SELECT * FROM t_expert WHERE status = 1 AND (find_in_set(%s,activeregion) OR activeregion=130000) order by priority desc LIMIT %s,%s", $jsonObj->activeregion,$jsonObj->start,$jsonObj->count);
                        if('%'==$jsonObj->activeregion){
                            $sql = sprintf("SELECT * FROM t_expert WHERE status = 1 order by priority desc LIMIT %s,%s", $jsonObj->start,$jsonObj->count);
                        }
                    }
                    else if('%'==$jsonObj->activeregion){
                        $sql = sprintf("SELECT * FROM t_expert WHERE status = 1 AND  find_in_set(%s,domain) order by priority desc LIMIT %s,%s", $jsonObj->domain,$jsonObj->start,$jsonObj->count);
                    }else{
                        $sql = sprintf("SELECT * FROM t_expert WHERE status = 1 AND  find_in_set(%s,domain) AND (find_in_set(%s,activeregion) OR activeregion=130000) order by priority desc LIMIT %s,%s", $jsonObj->domain,$jsonObj->activeregion,$jsonObj->start,$jsonObj->count);
                    }


                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();

                    if(empty($expert)){
                            $arr['rscode']=1;
                            $arr['error']='用户不存在';
                            return $arr;    
                    }

                    return $expert;
            } catch(\Exception $e) {
                    Yii::error("Expert::getExpertList error is ".$e->getMessage()."\n");
                    return 1;
            } 
    }
    static function searchExpertAndQuestion($jsonObj){
        if($jsonObj->type != 2){
            $findQuestion = \frontend\models\QuestionAnswer::find()->where(['like','questionsubject',$jsonObj->keys]);
            //$findQuestion->andwhere(['answer!=""']);
            $findQuestion->andwhere(['like','answer','http']);
        }
        if($jsonObj->type != 3){
            $findExpert = static::find()->where(['or',['like','introduction',$jsonObj->keys],['like','name',$jsonObj->keys]]);
            $findExpert->andwhere(['status'=>1]);
            // var_dump($findExpert->all());
        }
        switch($jsonObj->type){
            case '1':
            $res['expert'] = $findExpert->limit(6)->orderBy(['praisecnt'=>SORT_DESC])->asArray()->all();
            $res['question'] = $findQuestion->limit(6)->orderBy(['listenedcnt'=>SORT_DESC])->asArray()->all();
            break;
            case '2':
            $res['expert'] = $findExpert->orderBy(['praisecnt'=>SORT_DESC])->limit(10)->offset($jsonObj->start)->asArray()->all();
            break;
            case '3':
            $res['question'] = $findQuestion->orderBy(['praisecnt'=>SORT_DESC])->limit(10)->offset($jsonObj->start)->asArray()->all();
            break;
        }
        return $res;
    }

    public static function getExpertInfo($expertid)
    {
        return static::findOne($expertid);
    }

    public static function addPraiseCnt($jsonObj)
    {
        try{
            Yii::error("request is ".print_r($jsonObj,1)."\n");
            
            $expert = \frontend\models\Expert::getExpertInfo($jsonObj->expertid);
            $expert->praisecnt += $jsonObj->praisecnt;
            $expert->save();
            
            $arr['rscode']=0;
            return $arr;
        } catch(\Exception $e) {
            Yii::error("Expert::AddPraiseCnt error is ".$e->getMessage()."\n");
            return $e->getMessage();
        }
    }
}

?>

<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Resume extends ActiveRecord
{
	public static function tableName()
    {
        return 't_resume';
    }

    public static function addResume($jsonObj)
    {
        try{
            Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
            $resume=new Resume();
            $resume->userid=$jsonObj->userid;
            $resume->usertype=$jsonObj->usertype;
            $resume->userheadpic=$jsonObj->userheadpic;
            $resume->realname=$jsonObj->realname;
            $resume->organization=$jsonObj->organization;
            $resume->city=$jsonObj->city;
            $resume->workperiod=$jsonObj->workperiod;
            $resume->homecity=$jsonObj->homecity;
            $resume->age=$jsonObj->age;
            $resume->phone=$jsonObj->phone;
            $resume->resumedetail=$jsonObj->resumedetail;
            $resume->position=$jsonObj->position;
            $resume->education=$jsonObj->education;
            $resume->validflag = 1;
            Yii::error("resume is ".print_r($resume,1)."\n");
            $resume->save();
            $arr['rscode']=0;
            return $arr;
        }catch (\Exception $e) {
            Yii::error("Resume::addResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function modifyResume($jsonObj)
    {
        try{
            Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

            $resume=static::find()->where(['id'=>$jsonObj->resumeid])->one();
            if(!empty($resume))
            {
                $resume->userid=$jsonObj->userid;
                $resume->usertype=$jsonObj->usertype;
                $resume->userheadpic=$jsonObj->userheadpic;
                $resume->realname=$jsonObj->realname;
                $resume->organization=$jsonObj->organization;
                $resume->city=$jsonObj->city;
                $resume->workperiod=$jsonObj->workperiod;
                $resume->homecity=$jsonObj->homecity;
                $resume->age=$jsonObj->age;
                $resume->phone=$jsonObj->phone;
                $resume->resumedetail=$jsonObj->resumedetail;
                $resume->position=$jsonObj->position;
                 $resume->education=$jsonObj->education;
                $resume->validflag = 1;
                Yii::error("modifyResume::resume is ".print_r($resume,1)."\n");
                $resume->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("modifyResume::resumeid $jsonObj->resumeid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
            
        }catch (\Exception $e) {
            Yii::error("Resume::modifyResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function deleteResume($jsonObj)
    {
        try{
            Yii::error("deleteResume::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resume=static::find()->where(['id'=>$jsonObj->resumeid])->one();
            if(!empty($resume))
            {
                $resume->validflag=0;
                Yii::error("deleteResume::resume is ".print_r($resume,1)."\n");
                $resume->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("deleteResume::id $jsonObj->resumeid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("Resume::deleteResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function getResume($jsonObj)
    {
        try{
            Yii::error("getResume::jsonObj is : ".print_r($jsonObj,1)."\n");
            $resume=static::find()->where(['id'=>$jsonObj->resumeid])->andWhere(['validflag'=>1])->asArray()->one();
            return $resume;
        }catch (\Exception $e) {
            Yii::error("Resume::getResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function getResumeByUserId($jsonObj)
    {
        try{
            Yii::error("getResume::jsonObj is : ".print_r($jsonObj,1)."\n");
            $resume=static::find()->where(['userid'=>$jsonObj->userid])->andWhere(['validflag'=>1])->asArray()->one();
            return $resume;
        }catch (\Exception $e) {
            Yii::error("Resume::getResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetResumeListByRecruitid($jsonObj)
    {
        try{
            Yii::error("GetResumeListByRecruitid::jsonObj is : ".print_r($jsonObj,1)."\n");
            $connection = Yii::$app->db;

            $sql = sprintf("SELECT * FROM v_resume_delivery where recruitid=".$jsonObj->recruitid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $resume_deliver = $command->queryAll();
            $res['deliver_count'] = count($resume_deliver);

            $sql = sprintf("SELECT * FROM v_resume_delivery WHERE status=1 and recruitid=".$jsonObj->recruitid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $resume_handled = $command->queryAll();
            $res['handled_count'] = count($resume_handled);

            $res['unhandled_count']=$res['deliver_count']-$res['handled_count'];
            $res['resumelist'] = $resume_deliver;
            return $res;
        }catch (\Exception $e) {
            Yii::error("Resume::GetResumeListByRecruitid error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetResumeListUnhandled($jsonObj)
    {
        try{
            Yii::error("GetResumeListByRecruitid::jsonObj is : ".print_r($jsonObj,1)."\n");
            $connection = Yii::$app->db;

            $sql = sprintf("SELECT * FROM v_resume_delivery WHERE status=0 and recruituserid=".$jsonObj->userid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $resume_list = $command->queryAll();
           
            return $resume_list;
        }catch (\Exception $e) {
            Yii::error("Resume::GetResumeListUnhandled error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetResumeListAll($jsonObj)
    {
        try{
            Yii::error("GetResumeListByRecruitid::jsonObj is : ".print_r($jsonObj,1)."\n");
            $connection = Yii::$app->db;

            $sql = sprintf("SELECT count(*) as cnt FROM v_resume_delivery where recruituserid=".$jsonObj->userid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $resumecnt = $command->queryAll();
            $res['resumecnt'] = $resumecnt[0]['cnt'];

            $sql = sprintf("SELECT count(*) as cnt  FROM v_resume_delivery where status=0 and recruituserid=".$jsonObj->userid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $notdealedcnt = $command->queryAll();
            $res['notdealedcnt'] = $notdealedcnt[0]['cnt'];

            $sql = sprintf("SELECT count(*) as cnt FROM v_resume_delivery where status=1 and recruituserid=".$jsonObj->userid);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $dealedcnt = $command->queryAll();
            $res['dealedcnt'] = $dealedcnt[0]['cnt'];

            $sql = sprintf("SELECT * FROM v_resume_delivery WHERE recruituserid=%s limit %s,%s",$jsonObj->userid,$jsonObj->start,$jsonObj->count);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $resume_list = $command->queryAll();
            $res['resumelist'] = $resume_list;
            return $res;
        }catch (\Exception $e) {
            Yii::error("Resume::GetResumeListUnhandled error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }


    public static function GetRecruitListByResumeid($jsonObj)
    {
        try{
            Yii::error("GetRecruitListByResumeid::jsonObj is : ".print_r($jsonObj,1)."\n");
            $connection = Yii::$app->db;

            $sql = sprintf("SELECT * FROM v_resume_delivery WHERE deliveryuserid=%s AND resumeid=%s LIMIT %s,%s", $jsonObj->userid, $jsonObj->resumeid, $jsonObj->start, $jsonObj->count);
            Yii::error("sql is ".$sql."\n");
            $command = $connection->createCommand($sql);
            $res = $command->queryAll();
            return $res;
        }catch (\Exception $e) {
            Yii::error("Resume::GetRecruitListByResumeid error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }
    
}

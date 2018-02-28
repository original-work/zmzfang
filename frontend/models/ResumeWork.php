<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Resume;

class ResumeWork extends ActiveRecord
{
	public static function tableName()
    {
        return 't_resume_work';
    }

    public static function addResumeWork($jsonObj)
    {
        try{
            Yii::error("addResumeWork::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resume=Resume::find()->where(['id'=>$jsonObj->resumeid])->one();
            if(!empty($resume))
            {
                $resumework=new ResumeWork();
                $resumework->userid=$jsonObj->userid;
                $resumework->resumeid=$jsonObj->resumeid;
                
                $resumework->organization=$jsonObj->organization;
                $resumework->position=$jsonObj->position;
                $resumework->begindate=date('Y-m-d H:i:s',time());
                $resumework->enddate=date('Y-m-d H:i:s',time());
                $resumework->workdetail=$jsonObj->workdetail;
                $resumework->validflag=1;
                Yii::error("resumework is ".print_r($resumework,1)."\n");
                $resumework->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("ResumeWork::addResumeWork error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function modifyResumeWork($jsonObj)
    {
        try{
            Yii::error("modifyResumeWork::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resumework=static::find()->where(['workid'=>$jsonObj->workid])->one();
            if(!empty($resumework))
            {
                $resumework->resumeid=$jsonObj->resumeid;
                $resumework->userid=$jsonObj->userid;
                $resumework->organization=$jsonObj->organization;
                $resumework->position=$jsonObj->position;
                $resumework->begindate=$jsonObj->begindate;
                $resumework->enddate=$jsonObj->enddate;
                $resumework->workdetail=$jsonObj->workdetail;
                Yii::error("modifyResume::resumework is ".print_r($resumework,1)."\n");
                $resumework->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("modifyResume::resumeid $jsonObj->resumeid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
            
        }catch (\Exception $e) {
            Yii::error("ResumeWork::modifyResume error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function deleteResumeWork($jsonObj)
    {
        try{
            Yii::error("deleteResumeWork::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resumework=static::find()->where(['workid'=>$jsonObj->workid])->one();
            if(!empty($resumework))
            {
                $resumework->validflag=0;

                Yii::error("deleteResumeWork::resumework is ".print_r($resumework,1)."\n");
                $resumework->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("deleteResumeWork::workid $jsonObj->workid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("ResumeWork::deleteResumeWork error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function getResumeWork($jsonObj)
    {
        try{
            Yii::error("getResumeWork::jsonObj is : ".print_r($jsonObj,1)."\n");
            $resumework=static::find()->where(['workid'=>$jsonObj->workid])->asArray()->one();
            return $resumework;
        }catch (\Exception $e) {
            Yii::error("getResumeWork::error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetResumeWorkList($jsonObj)
    {
        Yii::error("GetResumeWorkList::jsonObj is : ".print_r($jsonObj,1)."\n");
        //$res=static::find()->where(['resumeid'=>$jsonObj->resumeid])->andWhere(['userid'=>$jsonObj->userid])->andWhere(['validflag'=>1])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        $res=static::find()->where(['resumeid'=>$jsonObj->resumeid])->andWhere(['validflag'=>1])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        Yii::error("GetResumeWorkList:res is ".print_r($res,1)."\n");
        return $res;
    }
    
}

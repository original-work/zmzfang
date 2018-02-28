<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Resume;

class ResumeEdu extends ActiveRecord
{
	public static function tableName()
    {
        return 't_resume_edu';
    }

    public static function addResumeEdu($jsonObj)
    {
        try{
            Yii::error("addResumeEdu::jsonObj is : ".print_r($jsonObj,1)."\n");
            $resume=Resume::find()->where(['id'=>$jsonObj->resumeid])->one();
            if(!empty($resume))
            {
                $resume_edu=new ResumeEdu();
                $resume_edu->resumeid=$jsonObj->resumeid;
                $resume_edu->userid=$jsonObj->userid;
                $resume_edu->schoolinfo=$jsonObj->schoolinfo;
                $resume_edu->major=$jsonObj->major;
                $resume_edu->education=$jsonObj->education;
                $resume_edu->begindate=date('Y-m-d H:i:s',time());
                $resume_edu->enddate=date('Y-m-d H:i:s',time());
                $resume_edu->validflag=1;
                
                Yii::error("resume_edu is ".print_r($resume_edu,1)."\n");
                $resume_edu->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("ResumeEdu::addResumeEdu error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function modifyResumeEdu($jsonObj)
    {
        try{
            Yii::error("modifyResumeEdu::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resume_edu=static::find()->where(['eduid'=>$jsonObj->eduid])->one();
            if(!empty($resume_edu))
            {
                $resume_edu->resumeid=$jsonObj->resumeid;
                $resume_edu->userid=$jsonObj->userid;
                $resume_edu->schoolinfo=$jsonObj->schoolinfo;
                $resume_edu->major=$jsonObj->major;
                $resume_edu->education=$jsonObj->education;
                $resume_edu->begindate=$jsonObj->begindate;
                $resume_edu->enddate=$jsonObj->enddate;
                Yii::error("modifyResumeEdu::resume_edu is ".print_r($resume_edu,1)."\n");
                $resume_edu->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("modifyResumeEdu::resumeid $jsonObj->eduid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
            
        }catch (\Exception $e) {
            Yii::error("ResumeEdu::modifyResumeEdu error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function deleteResumeEdu($jsonObj)
    {
        try{
            Yii::error("deleteResumeEdu::jsonObj is : ".print_r($jsonObj,1)."\n");

            $resume_edu=static::find()->where(['eduid'=>$jsonObj->eduid])->one();
            if(!empty($resume_edu))
            {
                $resume_edu->validflag=0;

                Yii::error("deleteResumeEdu::resume_edu is ".print_r($resume_edu,1)."\n");
                $resume_edu->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("deleteResumeEdu::eduid $jsonObj->eduid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("deleteResumeEdu::error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function getResumeEdu($jsonObj)
    {
        try{
            Yii::error("getResumeEdu::jsonObj is : ".print_r($jsonObj,1)."\n");
            $resume_edu=static::find()->where(['eduid'=>$jsonObj->eduid])->asArray()->one();
            return $resume_edu;
        }catch (\Exception $e) {
            Yii::error("getResumeEdu::error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetResumeEduList($jsonObj)
    {
        Yii::error("GetResumeEduList::jsonObj is : ".print_r($jsonObj,1)."\n");
        //$res=static::find()->where(['resumeid'=>$jsonObj->resumeid])->andWhere(['userid'=>$jsonObj->userid])->andWhere(['validflag'=>1])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        $res=static::find()->where(['resumeid'=>$jsonObj->resumeid])->andWhere(['validflag'=>1])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        Yii::error("GetResumeEduList:res is ".print_r($res,1)."\n");
        return $res;
    }
    
}

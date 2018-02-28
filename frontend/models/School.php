<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class School extends ActiveRecord
{
	public static function tableName()
    {
        return 't_school_district';
    }

    public static function GetSchoolInfo($jsonObj)
    {
        try{
                Yii::trace("request is ".print_r($jsonObj,1)."\n");
                $res = School::find()->where(['city' => $jsonObj->city])->orderBy('id')->asArray()->all();
                Yii::trace("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("School::GetSchoolInfo error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

?>
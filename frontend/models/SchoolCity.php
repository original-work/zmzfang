<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class SchoolCity extends ActiveRecord
{
	public static function tableName()
    {
        return 't_school_city';
    }

    public static function GetSchoolMatch($jsonObj)
    {
        try{
                Yii::error("request is ".print_r($jsonObj,1)."\n");
                Yii::error("jsonObj->keys is ".$jsonObj->keys."\n");

                $res = SchoolCity::find()->select(['id','name','place'])->where(['like', 'name', $jsonObj->keys])->limit(30)->orderBy('id')->asArray()->all();
                Yii::error("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("SchoolCity::GetSchoolMatch error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

?>
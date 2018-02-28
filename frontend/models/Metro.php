<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Metro extends ActiveRecord
{
	public static function tableName()
    {
        return 't_metro';
    }

    public static function GetMetroInfo($jsonObj)
    {
        try{
                Yii::trace("request is ".print_r($jsonObj,1)."\n");
                $res = Metro::find()->where(['city' => $jsonObj->city])->orderBy('id')->asArray()->all();
                Yii::trace("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("Metro::GetMetroInfo error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

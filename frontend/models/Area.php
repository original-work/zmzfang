<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Area extends ActiveRecord
{
	public static function tableName()
    {
        return 't_area';
    }

    public static function GetAreaInfo($jsonObj)
    {
        try{
                Yii::trace("request is ".print_r($jsonObj,1)."\n");
                $res = Area::find()->where(['city' => $jsonObj->city])->orderBy('id')->asArray()->all();
                Yii::trace("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("Area::GetAreaInfo error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

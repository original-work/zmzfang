<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class HotKey extends ActiveRecord
{
	public static function tableName()
    {
        return 't_hotkey';
    }

    public static function GetSearchHotKey($jsonObj)
    {
        try{
                Yii::trace("request is ".print_r($jsonObj,1)."\n");
                Yii::trace("jsonObj->keytype is ".$jsonObj->keytype."\n");

                $res = HotKey::find()->where(['keytype' => $jsonObj->keytype])->orderBy('id')->asArray()->all();
                Yii::trace("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("HotKey::GetSearchHotKey error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

?>
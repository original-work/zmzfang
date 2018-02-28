<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Config extends ActiveRecord
{
	public static function tableName()
    {
        return 't_hotkey';
    }

    public static function getSearchParams($jsonObj)
    {
        return static::find()->select('id,hotkey,keytype')->where(['keytype'=>$jsonObj->keytype,'validflag'=>1])->asArray()->all();
    }
}

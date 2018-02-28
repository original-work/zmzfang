<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class AccountDetail extends ActiveRecord
{
	public static function tableName()
    {
        return 't_account_detail';
    }

    public static function getAccountDetail($userid,$usertype,$count,$start)
    {
        return static::find()->where(['userid'=>$userid,'usertype'=>$usertype])->
        limit($count)->offset($start)->orderBy('createtime DESC')->asArray()->all();
    }
    
}

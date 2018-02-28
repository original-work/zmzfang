<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class OrgLogo extends ActiveRecord
{
	public static function tableName()
    {
        return 't_organization_logo';
    }

    public static function logos()
    {
        return static::find()->where(['validflag'=>1])->asArray()->all();
    }
}

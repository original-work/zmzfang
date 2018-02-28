<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Token extends ActiveRecord
{
    public static function tableName()
    {
        return 't_token';
    }
}
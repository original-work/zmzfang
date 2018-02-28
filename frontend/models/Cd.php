<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Cd extends ActiveRecord
{
    public static function tableName()
    {
        return 't_cd';
    }
}
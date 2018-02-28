<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Cd extends ActiveRecord {

	public static function tableName()
    {
        return 't_cd';
    }
}
<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Rent extends ActiveRecord {

	public static function tableName()
    {
        return 't_requirement_rent';
    }
}
<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Pic extends ActiveRecord {

	public static function tableName()
    {
        return 't_house_picture';
    }
}
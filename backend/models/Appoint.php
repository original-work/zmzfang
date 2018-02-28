<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Appoint extends ActiveRecord {

	public static function tableName()
    {
        return 't_expert_appointment';
    }
}
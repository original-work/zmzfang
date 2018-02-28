<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Bid extends ActiveRecord {

	public static function tableName()
    {
        return 't_house_bid';
    }
}
<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Order extends ActiveRecord {

	public static function tableName()
    {
        return 't_wx_order';
    }
}
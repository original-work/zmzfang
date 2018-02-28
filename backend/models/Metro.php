<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class Metro extends ActiveRecord {
	public static function tableName()
    {
        return 't_metro';
    }
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['metroline','regioname', 'text', 'value','longitude','latitude','region'], 'safe'],
        ];
    }

}
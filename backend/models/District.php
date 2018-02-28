<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class District extends ActiveRecord {
	public static function tableName()
    {
        return 't_residential_district';
    }
    public function rules()
    {
        return [
            [['districtid'], 'integer'],
            [['districtname', 'address', 'completedtime', 'region', 'plate','latitude','longitude'], 'safe'],
            [['latitude', 'longitude'], 'number'],
        ];
    }
}
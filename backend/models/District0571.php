<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class District0571 extends ActiveRecord {
	public static function tableName()
    {
        return 't_residential_district_0571';
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
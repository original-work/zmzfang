<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class School extends ActiveRecord {
	public static function tableName()
    {
        return 't_school_district';
    }
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['city','region', 'plate','schoolname', 'schoolid','districtids','districtnames'], 'safe'],
        ];
    }
    
}
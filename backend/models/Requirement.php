<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class Requirement extends ActiveRecord {
	public static function tableName()
    {
        return 't_requirement';
    }
    public function rules()
    {
        return [
            [['id', 'publishuserid', 'publishusertype', 'requirementtype', 'acceptagentflag'], 'integer'],
            [['region1', 'region2', 'region3', 'districtid', 'districtname', 'budget', 'housetype', 'storey', 'buildingtype', 'detail', 'dividefeedescribe', 'updatetime', 'createtime', 'dividerate', 'subject', 'validflag'], 'safe'],
            [['agentfee', 'expectdividefee'], 'number'],
        ];
    }
    public function getuser()
    {
        return $this->hasOne(User::className(), ['id' => 'publishuserid']);
    }

}
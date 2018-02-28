<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Cash extends ActiveRecord {
	public static function tableName()
    {
        return 't_withdraw_cash';
    }
    public function rules()
    {
        return [
            [['id', 'userid', 'usertype', 'status', 'validflag'], 'integer'],
            [['amount'], 'number'],
            [['createtime', 'updatetime'], 'safe'],
        ];
    }
}
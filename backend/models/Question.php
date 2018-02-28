<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Question extends ActiveRecord {
	public function rules()
    {
        return [
            [['id', 'userid', 'expertid', 'openflag', 'listenedcnt', 'duration', 'priority'], 'integer'],
            [['questionsubject', 'questiondetail', 'answer', 'questiondate', 'anserdate'], 'safe'],
        ];
    }
	public static function tableName()
    {
        return 't_question_answer';
    }
}
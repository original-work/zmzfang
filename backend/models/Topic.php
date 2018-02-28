<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Topic extends ActiveRecord {
	public function rules()
    {
        return [
            [['id', 'count', 'time_start','time_end'], 'integer'],
            [['title', 'describe', 'picture', 'time_start','time_end', 'count','status','short_desc','read','source'], 'safe'],
        ];
    }
	public static function tableName()
    {
        return 't_topic';
    }
}
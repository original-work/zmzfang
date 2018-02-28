<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Topic extends ActiveRecord
{
    public static function tableName()
    {
        return 't_topic';
    }
    public function getCount()
    {
        return $this->hasMany(TopicContent::className(), ['topic_id' => 'id']);
    }
}
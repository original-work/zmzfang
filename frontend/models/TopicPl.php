<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class TopicPl extends ActiveRecord
{
    public static function tableName()
    {
        return 't_topic_pl';
    }
}
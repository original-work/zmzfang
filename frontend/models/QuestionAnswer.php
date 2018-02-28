<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class QuestionAnswer extends ActiveRecord
{
	public static function tableName()
    {
        return 'v_question_answer';
    }
}

?>
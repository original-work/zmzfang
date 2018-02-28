<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class ExpertAppointment extends ActiveRecord
{
	public static function tableName()
    {
        return 't_expert_appointment';
    }    
}

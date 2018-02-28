<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class ExpertAppointmentStatus extends ActiveRecord
{
	public static function tableName()
    {
        return 't_expert_appointment_status';
    }    
}

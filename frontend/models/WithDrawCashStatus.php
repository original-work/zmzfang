<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class WithDrawCashStatus extends ActiveRecord
{
	public static function tableName()
    {
        return 't_withdraw_cash_status';
    }
}

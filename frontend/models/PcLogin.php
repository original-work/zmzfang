<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class PcLogin extends ActiveRecord
{
	public static function tableName()
    {
        return 'pc_login';
    }
}

<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;


class Advertisement extends ActiveRecord
{

    public static function tableName()
    {
        return 't_advertisement';
    }

	public static function getAdvertisement($locationid)
	{
			return static::find()->where(['locationid'=>$locationid])->orderBy('sn ASC')->asArray()->all();
	}
	
	public static function getAdvertisementDetail($advertisementid)
	{
			$sql='select * from t_advertisement_detail where advertisementid='.$advertisementid.' order by sn asc';
			return static::findBySql($sql)->asArray()->all();
	}
}

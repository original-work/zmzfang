<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\utils\CommonFun;

class ResidentialInfo extends ActiveRecord
{
	public static function tableName()
    {
        return 't_residential_district'.CITY;
    }

    public static function GetDistrictMatch($jsonObj)
    {
        try{
                Yii::error("request is ".print_r($jsonObj,1)."\n");
                Yii::error("jsonObj->keys is ".$jsonObj->keys."\n");
                //$city = $jsonObj->city;
                //$cityno = CommonFun::getCityNoByCityName($city);
                //$model = (new \yii\db\Query())->select(['districtid','districtname','address'])->from('t_residential_district_'.$cityno)->where(['like', 'districtname', $jsonObj->keys])->orderBy('districtid')->limit(30);

                $res = ResidentialInfo::find()->select(['districtid','districtname','address'])->where(['like', 'districtname', $jsonObj->keys])->limit(30)->orderBy('districtid')->asArray()->all();
                //$res = $model->all();
                Yii::error("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("ResidentialInfo::GetDistrictMatch error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
}

?>
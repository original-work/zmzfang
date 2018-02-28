<?php

namespace common\helpers;

use Yii;

class AreaConf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_area';
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    { 
        return [
            [['city', 'region', 'plate', 'code'], 'required'],
            [['province', 'city'], 'string', 'max' => 30],
            [['region', 'plate'], 'string', 'max' => 40],
            [['code'], 'string', 'max' => 10]
        ]; 
    }

    static function getCity(){
    	return static::find()->groupBy('city')->asArray()->all();
    }
    static function getRegion($c){
    	return static::find()->where(['city'=>$c])->groupBy('region')->asArray()->all();
    }
    static function getPlate($c){
    	return static::find()->where(['plate'=>$p])->groupBy('plate')->asArray()->all();
    }
    static function php2json($c){
    	$arr = static::find()->where(['city'=>$c])->orderBy(['code'=>SORT_ASC])->asArray()->all();
    	$sortArr = [];
    	foreach ($arr as  $value) {
    		$sortArr['block'][substr($value['code'],6,2)][$value['code']]=$value;
    		if(count($sortArr['region']) == 0 || !array_key_exists(substr($value['code'],6,2), $sortArr['region'])){
    			$sortArr['region'][substr($value['code'],6,2)]=$value['region'];
    		}
    	}
    	return $sortArr;
    }
}

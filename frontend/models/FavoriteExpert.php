<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class FavoriteExpert extends ActiveRecord
{
	public static function tableName()
    {
        return 't_favorite_expert';
    }

    public static function addFavoriteExpert($jsonObj)
    {
		try{
				$expert=new FavoriteExpert();
                Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                $count=static::find()->where(['userid'=>$jsonObj->userid,'expertid'=>$jsonObj->expertid])->count();
                if($count>0){
                    Yii::error("addFavoriteExpert:Already have this expert\n");
                    $arr['rscode']=0;
                    return $arr;
                }
				$expert->userid=$jsonObj->userid;
				$expert->expertid=$jsonObj->expertid;
				$expert->save();
				$arr['rscode']=0;
			    return $arr;
		} catch(\Exception $e) {
                Yii::error("FavoriteExpert::addFavoriteExpert error is ".$e->getMessage()."\n");
			    return 1;
		} 
    }

    public static function getFavoriteExpert($jsonObj)
    {
        try{
                return static::find()->where(['userid'=>$jsonObj->userid])->limit($jsonObj->count)->offset($jsonObj->start)
                ->asArray()->all();

        } catch(\Exception $e) {
                Yii::error("FavoriteExpert::getFavoriteExpert error is ".$e->getMessage()."\n");
                return 1;
        } 
    }

    public static function deleteFavoriteExpert($jsonObj)
    {
        try{
                $expert=static::find()->where(['userid'=>$jsonObj->userid,'expertid'=>$jsonObj->expertid])->one();
                if($expert->count()){
                    $expert->delete();
                }
                $arr['rscode']=0;
                return $arr;
        } catch(\Exception $e) {
                Yii::error("FavoriteExpert::deleteFavoriteExpert error is ".$e->getMessage()."\n");
                return 1;
        }
    }
    
    public static function isFavoriteExpert($jsonObj)
    {
        try{
                return static::find()->where(['userid'=>$jsonObj->userid,'expertid'=>$jsonObj->expertid])->count();
                
        } catch(\Exception $e) {
                Yii::error("FavoriteExpert::isFavoriteExpert error is ".$e->getMessage()."\n");
                return 1;
        } 
    }

}

?>
<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Recruit;
use frontend\models\User;

class FavoritePosition extends ActiveRecord
{
	public static function tableName()
    {
        return 't_favorite_position';
    }

    public static function AddFavoritePosition($jsonObj)
    {
        try{
            Yii::error("AddFavoritePosition::jsonObj is : ".print_r($jsonObj,1)."\n");

            $position = Recruit::find()->where(['recruitid' => $jsonObj->recruitid])->one();
            Yii::error("position is ".print_r($position,1)."\n");

            $user = User::find()->where(['id' => $jsonObj->userid])->one();
            Yii::error("user is ".print_r($user,1)."\n");

            if(!empty($position)&&!empty($user)){
                $favorite_position=new FavoritePosition();
                $favorite_position->userid=$jsonObj->userid;
                $favorite_position->recruitid=$jsonObj->recruitid;
                $favorite_position->createtime=date('Y-m-d H:i:s',time());
                $favorite_position->validflag=1;
                
                Yii::error("favorite_position is ".print_r($resume_edu,1)."\n");
                $favorite_position->save();
                $arr['rscode']=0;
            }else{
                Yii::error("AddFavoritePosition: position ".$position." or user ".$user." not exist\n");
                $arr['rscode']=1;
            }            
            return $arr;
        }catch (\Exception $e) {
            Yii::error("FavoritePosition::AddFavoritePosition error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function GetFavoritePosition($jsonObj)
    {
        try{
            Yii::error("GetFavoritePosition::jsonObj is : ".print_r($jsonObj,1)."\n");

            $sql = sprintf("SELECT a.* FROM v_recruit a ,t_favorite_position b where a.recruitid=b.recruitid and b.validflag=1 and a.validflag=1 and b.userid=%s LIMIT %s,%s", $jsonObj->userid, $jsonObj->start, $jsonObj->count);
            Yii::error("sql is ".$sql."\n");

            $connection = Yii::$app->db;
            $command = $connection->createCommand($sql);
            $recruit = $command->queryAll();
           
            return $recruit;
          
        }catch (\Exception $e) {
            Yii::error("FavoritePosition::GetFavoritePosition error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }


    public static function DeleteFavoritePosition($jsonObj)
    {
        try{
            Yii::error("DeleteFavoritePosition::jsonObj is : ".print_r($jsonObj,1)."\n");

            $favorite_position=static::find()->where(['userid'=>$jsonObj->userid])->andWhere(['recruitid'=>$jsonObj->recruitid])->one();
            if(!empty($favorite_position))
            {
                $favorite_position->validflag=0;
                Yii::error("DeleteFavoritePosition::favorite_position is ".print_r($favorite_position,1)."\n");
                $favorite_position->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("DeleteFavoritePosition::userid $jsonObj->userid recruitid $jsonObj->recruitid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("FavoritePosition::DeleteFavoritePosition error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function IsFavoritePosition($jsonObj)
    {
        try{
            Yii::error("IsFavoritePosition::jsonObj is : ".print_r($jsonObj,1)."\n");

            $favorite_position=static::find()->where(['userid'=>$jsonObj->userid])->andWhere(['recruitid'=>$jsonObj->recruitid])->one();
            if(!empty($favorite_position))
            {
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("IsFavoritePosition::userid $jsonObj->userid recruitid $jsonObj->recruitid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("FavoritePosition::IsFavoritePosition error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    
}

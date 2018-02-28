<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class FavoriteRequirement extends ActiveRecord
{
		public static function tableName()
    {
        return 't_favorite_requirement';
    }
	
    public static function getUserFavoriteRequirement($userid)
    {
				$sql='SELECT t_requirement.*,t_user.nickname,t_user.picture FROM t_requirement JOIN t_user ON t_user.id=t_requirement.publishuserid  WHERE t_requirement.id IN (SELECT requirementid FROM t_favorite_requirement WHERE userid='.$userid.')';
				return static::findBySql($sql)->asArray()->all();
    }
    
    public static function deleteFavoriteRequirement($userid,$requirementid)
    {
    		try{
    				$reqlist=static::getFavoriteRequirement($userid,$requirementid);
    				if(empty($reqlist)){
    						$arr['rscode']=1;
				    		$arr['error']='没找到对应记录';
				    		return $arr;
    				}
    				foreach($reqlist as $req){
    						$req->delete();
    				}
    				$arr['rscode']=0;
				    return $arr;
    		} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				} 
    }
    
    public static function addFavoriteRequirement($userid,$requirementid)
    {
    		try{
    				$reqlist=static::getFavoriteRequirement($userid,$requirementid);
    				if(!empty($reqlist)){
    						$arr['rscode']=1;
				    		$arr['error']='记录已经存在';
				    		return $arr;
    				}
    				$req = new FavoriteRequirement();
    				$req->userid=$userid;
    				$req->requirementid=$requirementid;
    				$req->date=date('y-m-d H:i:s',time());
    				$req->save();
    				$arr['rscode']=0;
				    return $arr;
    		} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				} 
    }
    
    public static function getFavoriteRequirement($userid,$requirementid)
    {
    		return static::findAll(['userid'=>$userid,'requirementid'=>$requirementid]);
    }

    public static function isFavoriteRequirement($jsonObj)
    {
            try{
                    $reqlist=static::getFavoriteRequirement($jsonObj->userid,$jsonObj->requirementid);
                    if(empty($reqlist)){
                            $arr['rscode']=1;
                            $arr['error']='没找到对应记录';
                            return $arr;
                    }else{
                            $arr['rscode']=0;
                            return $arr;
                    }
                    
            } catch(\Exception $e) {
                    $arr['rscode']=1;
                    $arr['error']=$e->getMessage();
                    return $arr;
            } 
    }

}

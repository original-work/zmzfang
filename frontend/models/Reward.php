<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Reward extends ActiveRecord
{
	public static function tableName()
	{
		return 't_reward';
	}
	function getSort($obj){
		$m = new static;
		$r = $m->geTotal($obj);
		$c = static::find()->where(['>','reward',$r])->count();
		return ['rescode'=>0,'sort'=>$c+1,'total'=>$r];
	}

	function geTotal($obj){
		if($f = static::find()->where(['userid'=>$obj->userid])->one()){
			return $f->reward;
		}else{
			return 0;
		}
		
	}
	function list(){
		if($f = static::find()->select('`t_reward`.*,`t_user`.nickname,`t_user`.picture')->leftJoin('t_user','t_user.id = t_reward.userid')->orderBy(['t_reward.reward'=>SORT_DESC,'t_reward.id'=>SORT_ASC])->limit(20)->asArray()->all()){
			return $f;
		}else{
			return [];
		}
		
	}
}
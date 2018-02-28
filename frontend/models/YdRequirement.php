<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class YdRequirement extends ActiveRecord
{
	public static function tableName()
	{
		return 't_requirement_yd';
	}
	
	static public function set($obj)
	{
		try{
			if($obj->id){
				$m = static::findOne($obj->id);
			}else{
				$m = new static;
				$m->createtime = date('Y-m-d H:i:s',time());
			}
			$m->publishuserid = $obj->publishuserid;
			$m->publishusertype = $obj->publishusertype;
			$m->updatetime = date('Y-m-d H:i:s',time());
			$m->region = $obj->region;
			$m->budget = $obj->budget;
			$m->housetype = $obj->housetype;
			$m->storey = $obj->storey;
			$m->buildingtype = $obj->buildingtype;
			$m->detail = $obj->detail;
			$m->subject = $obj->subject;
			if($m->save()){
				return ['rscode'=>0,'requirementid'=>$m->id];
			}else{
				return ['rscode'=>0,'error'=>'system error'];
			}
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}
	static public function get($obj)
	{
		try{
			$where['validflag'] = 1;
			if($obj->region){
				$where['region'] = $obj->region;
			}
			$m = static::find()->where($where)->orderBy(['updatetime'=>SORT_DESC])->limit($obj->limit)->offset($obj->offset)->asArray()->all();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	static public function getListByUserId($obj)
	{
		try{
			$m = static::find()->where(['validflag'=>1,'publishuserid'=>$obj->userid])->asArray()->all();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	static public function detail($obj)
	{
		try{
			$m = static::find()->where(['validflag'=>1,'id'=>$obj->id])->asArray()->one();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	public static function DelRequirementByRequirementid($jsonObj){
			try{
				$requirement = static::find()->where(['id'=>$jsonObj->id, 'validflag'=>1])->one();
				if($requirement==null){
					$arr['rscode']=1;
					$arr['error']='requirement not exist';
					return $arr;
				}
				$requirement->validflag=0;
				$requirement->save();
				$arr['rscode']=0;
				return $arr;
				} catch(\Exception $e) {
					Yii::error("YdRequirement::DelRequirementByRequirementid error is ".$e->getMessage()."\n");
					$arr['rscode']=1;
					$arr['error']=$e->getMessage();
	           	 	return $arr;
       	 	}
	}

	public static function searchRequirementLastest($jsonObj){
		$findRequiremnt = static::find()->from('v_requirement_yd')->limit($jsonObj->requirementCount)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		return $findRequiremnt;
	}


}

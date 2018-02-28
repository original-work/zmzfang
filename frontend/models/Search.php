<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Agent;

class Search extends ActiveRecord
{
	public static function tableName()
	{
		return 't_requirement';
	}

	public static function searchRequirement($jsonObj)
	{
		switch($jsonObj->type){
			case '1':
				$findRequiremnt = \frontend\models\Requirement::find()->from('v_requirement');
				$res['requirement'] = $findRequiremnt->where(['or',['or',['like','detail',$jsonObj->keys],['like','subject',$jsonObj->keys]],['like','city',$jsonObj->keys]])->andWhere(['validflag'=>1])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
				$findRent = \frontend\models\Rent::find()->from('v_requirement_rent');
				$res['rent'] = $findRent->where(['or',['or',['like','detail',$jsonObj->keys],['like','subject',$jsonObj->keys]],['like','city',$jsonObj->keys]])->andWhere(['validflag'=>1])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
				$HelpRent = \frontend\models\ForHelp::find()->from('v_requirement_help');
				$res['help'] = $HelpRent->where(['or',['like','forhelpdetail',$jsonObj->keys],['like','forhelpsubject',$jsonObj->keys]])->andWhere(['validflag'=>1])->andWhere('rewardflag = 0 or (rewardflag = 1 and status !=0 )')->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
			break;
			case '2':
				$findRequiremnt = \frontend\models\Requirement::find()->from('v_requirement');
				$res['requirement'] = $findRequiremnt->where(['or',['or',['like','detail',$jsonObj->keys],['like','subject',$jsonObj->keys]],['like','city',$jsonObj->keys]])->andWhere(['validflag'=>1])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
			break;
			case '3':
				$findRent = \frontend\models\Rent::find()->from('v_requirement_rent');
				$res['rent'] = $findRent->where(['or',['or',['like','detail',$jsonObj->keys],['like','subject',$jsonObj->keys]],['like','city',$jsonObj->keys]])->andWhere(['validflag'=>1])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
			break;
			case '4':
				$findHelp = \frontend\models\ForHelp::find()->from('v_requirement_help');
				$res['help'] = $findHelp->where(['or',['like','forhelpdetail',$jsonObj->keys],['like','forhelpsubject',$jsonObj->keys]])->andWhere(['validflag'=>1])->andWhere('rewardflag = 0 or (rewardflag = 1 and status !=0 )')->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
			break;
		}
		return $res;
	}

	public static function searchRequirementIndex($jsonObj){
		// if($jsonObj->start = 0){
			$requirementAllCount = \frontend\models\Requirement::find()->from('v_requirement')->Where(['validflag'=>1])->count();
			$rentAllCount = \frontend\models\Rent::find()->from('v_requirement_rent')->Where(['validflag'=>1])->count();
			$helpAllCount = \frontend\models\ForHelp::find()->from('v_requirement_help')->Where(['validflag'=>1])->count();
		// }
		if($jsonObj->requirementCount){
			$findRequiremnt = \frontend\models\Requirement::find()->from('v_requirement')->Where(['validflag'=>1])->limit($jsonObj->requirementCount)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		}
		if($jsonObj->rentCount){
			$findRent = \frontend\models\Rent::find()->from('v_requirement_rent')->Where(['validflag'=>1])->limit($jsonObj->rentCount)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		}
		
		if($jsonObj->helpCount){
			$findHelp = \frontend\models\ForHelp::find()->from('v_requirement_help')->Where(['validflag'=>1,'status'=>1])->limit($jsonObj->helpCount)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		}
		// $count = $jsonObj->reqirementCount+$jsonObj->rentCount+$jsonObj->helpCount;
		
		$res = [];
		while($findRequiremnt|| $findRent ||$findHelp){
			$random = mt_rand();
			$num = $random%3;
			switch($num){
				case 0:
					if($findRequiremnt){
						$push = array_shift($findRequiremnt);
						array_push($res,$push);
					}
				break;
				case 1:
					if($findRent){
						$push = array_shift($findRent);
						array_push($res,$push);
					}
				break;
				case 2:
					if($findHelp){
						$push = array_shift($findHelp);
						array_push($res,$push);
					}
				break;
			}
		}
		return(['requirementAllCount'=>$requirementAllCount,'rentAllCount'=>$rentAllCount,'helpAllCount'=>$helpAllCount,'data'=>$res]);
			
		
	}

	public static function searchRequirementLastest($jsonObj){
	
		$findRequiremnt = \frontend\models\Requirement::find()->from('v_requirement_lastest')->limit($jsonObj->requirementCount)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		return $findRequiremnt;
	}
	public static function searcht($jsonObj){
	
		$findRequiremnt = \frontend\models\Requirement::find()->from('v_requirement_lastest')->limit($jsonObj['requirementCount'])->offset($jsonObj['start'])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		return $findRequiremnt;
	}
	static function searchAgent($jsonObj){
		Yii::error("searchAgent:jsonObj is : ".print_r($jsonObj,1)."\n");
		$data = (new \yii\db\Query())->from('v_agent')->where(['agentflag'=>1]);
		if($jsonObj->keys){
			$data->andwhere(['or',['like','nickname',$jsonObj->keys],['or',['like','city',$jsonObj->keys],['or',['like','organization',$jsonObj->keys],['like','skill',$jsonObj->keys]]]]);
		}
		if ($jsonObj->hotKeyId){
			$config = \frontend\models\Config::find()->select('sql')->where(['id'=>$jsonObj->hotKeyId])->one();
			$data ->andwhere($config->sql);
			if('5' == $jsonObj->hotKeyId){
				$data ->andwhere(['like','nativeplace',$jsonObj->homecity]);
			}
		}
		if($jsonObj->area){
			if($jsonObj->area == 13){
				$data->andwhere(['city'=>'上海市']);
			}else{
				$data->andwhere(['like','activeregion',$jsonObj->area])->andwhere(['city'=>$jsonObj->city]);
			}
		}
		Yii::error(print_r($data->orderBy(['datacompleterate'=>SORT_DESC])->limit($jsonObj->count)->offset($jsonObj->start)->createCommand()->sql,1)."\n");
		Yii::error(print_r($data->orderBy(['datacompleterate'=>SORT_DESC])->limit($jsonObj->count)->offset($jsonObj->start)->createCommand()->params,1)."\n");
		
		return $data->orderBy(['datacompleterate'=>SORT_DESC])->limit($jsonObj->count)->offset($jsonObj->start)->all();
	}
	
}

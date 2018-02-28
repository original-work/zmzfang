<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Mission extends ActiveRecord
{
	public static function tableName()
	{
		return 't_mission';
	}
	static function getMissionInfo($obj){
		$mid = 1;
		// for ($mid=1; $mid < 3; $mid++) { 
			if(static::findOne(['userid'=>$obj->userid,'mid'=>$mid])){
				$status = 2;
			}else{
				switch($mid){
					case 1:
						$extraInfo = \frontend\models\Agent::getAgentExtra($obj);
						if($extraInfo['datacompleterate'] < 80){
							$status = 0;
						}else{
							$status = 1;
						}
					break;
					// case 2:
					// 	$extraInfo = (new \yii\db\Query())->where
					// 	if(){
					// 		$status = 0;
					// 	}else{
					// 		$status = 1;
					// 	}
				}
			}
			return ['status'=>$status];
	}


	static function setMissionInfo($obj){
		$info = static::getMissionInfo($obj);
		if($info['status'] == 1){
			$transaction = Yii::$app->db->beginTransaction(); 
			$model = new static;
			$model->mid = $obj->mid;
			$model->userid = $obj->userid;
			$model->time = time();

			switch ((int)$obj->mid) {
				case 1:
					$reward = 0.12;
					break;
				default:
					return ['status'=>0];
			}
			
			if($model->save()){
				$account_detail=new \frontend\models\AccountDetail();
				$account_detail->userid=$obj->userid;
				$account_detail->usertype= 1;
				$account_detail->sumdate=date("Ymd");
				$account_detail->accounttype=10;
				$account_detail->servicetype=3001;
				$account_detail->originalfee=$reward;
				$account_detail->actualfee=$reward;
				$account_detail->subject='任务红包';
				$account_detail->ordertype=6;
				$account_detail->createtime=date('y-m-d H:i:s',time());
				$account_detail->save();

				$account=\frontend\models\Account::find()->where(['userid' => $obj->userid])->one();
				if (!$account) {
					$account = new \frontend\models\Account();
				}
				$account->userid = $obj->userid;
				$account->usertype = 1;
				$account->openid = \frontend\models\User::find()->where(['id'=>$obj->userid])->one()->wxopenid;
				$account->historyincome += $reward;
				$account->historyprofit += $reward;
				$account->remainedprofit += $reward;
				$account->drawedprofit = $account->drawedprofit?$account->drawedprofit:0;
				$account->usedprofit = $account->usedprofit?$account->usedprofit:0;
				;
				$account->lockingprofit=$account->lockingprofit?$account->lockingprofit:0;
				$account->createtime=$account->createtime?$account->createtime:time();
				$account->updatetime=date('y-m-d H:i:s',time());
				$account->save();

				$transaction->commit();
				return ['status'=>1];
			}
		}
		$transaction->rollBack();
		return ['status'=>0];
	}

	static function getRewardAgent($obj){
		$oth = (new \yii\db\Query())->select('t_invite.userid,t_user.picture')->from('t_invite')->leftjoin('t_agent','t_invite.userid = t_agent.userid')->leftjoin('t_user','t_invite.userid = t_user.id')->where(['parent'=>$obj->userid])->all();
		foreach ($oth as $value) {
			$othA[] = $value['userid'];
		}
		$othC = count($oth);
		if($othC){
			$tth = (new \yii\db\Query())->select('t_invite.userid,t_user.picture')->from('t_invite')->leftjoin('t_agent','t_invite.userid = t_agent.userid')->leftjoin('t_user','t_invite.userid = t_user.id')->where(['in','parent',$othA])->all();
			return ['rescode'=>0,'oReward'=>$oth,'tReward'=>$tth];
		}else{
			return ['rescode'=>0,'oReward'=>[]];
		}
	}
	static function getReward($obj){
		$oth = (new \yii\db\Query())->select('userid,rewarded')->from('t_invite')->where(['parent'=>$obj->userid])->all();
		$othC= 0;
		foreach ($oth as $value) {
			$othA[] = $value['userid'];
			if($value['rewarded'] == 0){
				$othC++;
			}
		}
		if($othC){
			$tthC = (new \yii\db\Query())->from('t_invite')->where(['and',['in','parent',$othA],'Prewarded=0'])->count();
			return ['rescode'=>0,'oReward'=>$othC,'tReward'=>$tthC];
		}else{
			return ['rescode'=>0,'oReward'=>0,'tReward'=>0];
		}
	}
	static function reward($obj){
		// 查询 一级下线
		$oth = (new \yii\db\Query())->from('t_invite')->where(['parent'=>$obj->userid])->all();
		// 计算 一级下线未领取奖励数 $othC
		$othC= 0;
		foreach ($oth as $value) {
			$othA[] = $value['userid'];
			if($value['rewarded'] == 0){
				$othC++;
			}
		}
		if($othC){
			// 计算 二级下线未领取奖励数 $tthC
			$tthC = (new \yii\db\Query())->from('t_invite')->where(['in','parent',$othA])->andwhere(['Prewarded'=>0])->all();
		}else{
			return ['rescode'=>0];
		}

		$transaction = Yii::$app->db->beginTransaction();
		try {
			// 更新所有一级代理的领取奖励情况
			Yii::$app->db->createCommand()->update('t_invite',['rewarded' => 1], ['parent'=>intval($obj->userid)])->execute();
			if($othC){
				// 更新所有二级代理的领取奖励情况
				Yii::$app->db->createCommand()->update('t_invite',['Prewarded' => 1], ['in','parent',$othA])->execute();
			}
			
			$reward = round($othC,1) + round( (intval($tthC) * 0.2) ,1);
			// $reward = 1;
			if ($m = \frontend\models\Reward::find()->where(['userid'=>$obj->userid])->one()) {
				$m ->reward +=$reward;
				$m ->lastime = time();
				$m ->save();
			}else{
				$n = new \frontend\models\Reward();
				$n ->reward = $reward;
				$n ->userid = $obj->userid;
				$n ->lastime = time();
				$n ->save();
			}

			$account_detail=new \frontend\models\AccountDetail();
			$account_detail->userid=$obj->userid;
			$account_detail->usertype= 1;
			$account_detail->sumdate=date("Ymd");
			$account_detail->accounttype=10;
			$account_detail->servicetype=3001;
			$account_detail->originalfee=$reward;
			$account_detail->actualfee=$reward;
			$account_detail->subject='注册红包';
			$account_detail->ordertype=6;
			$account_detail->createtime=date('y-m-d H:i:s',time());
			$account_detail->save();

			$account=\frontend\models\Account::find()->where(['userid' => $obj->userid])->one();
			if (!$account) {
				$account = new \frontend\models\Account();
			}
			$account->userid = $obj->userid;
			$account->usertype = 1;
			$account->openid = \frontend\models\User::find()->where(['id'=>$obj->userid])->one()->wxopenid;
			$account->historyincome += $reward;
			$account->historyprofit += $reward;
			$account->remainedprofit += $reward;
			$account->drawedprofit = $account->drawedprofit?$account->drawedprofit:0;
			$account->usedprofit = $account->usedprofit?$account->usedprofit:0;
			$account->lockingprofit=$account->lockingprofit?$account->lockingprofit:0;
			$account->createtime=$account->createtime?$account->createtime:time();
			$account->updatetime=date('y-m-d H:i:s',time());
			$account->save();
			$transaction->commit();
			return ['rescode'=>0];
		}catch (Exception $e) {
			$transaction->rollBack();
			return ['rescode'=>1];
		}
	}

	static function pushInvite($obj){
		if( Yii::$app->db->createCommand()->insert('t_invite', [
		    'parent' => $obj->parent,
		    'userid' => $obj->userid,
		    'createtime'=>date('Y-m-d H:i:s',time())
		])->execute() ){
			return ['rescode'=>0];
		}else{
			return ['rescode'=>1];
		}
	}
}
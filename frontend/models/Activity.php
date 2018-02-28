<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;
use frontend\models\ActivityOrg;

class Activity extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_activity';
	}
	public function add($p){
		try{
			$m = new static;
			$m->publishuserid = $p['publishuserid'];
			$m->publishusertype = $p['publishusertype'];
			$agent = (new \yii\db\Query())->select('v_agent.*')->from('v_agent')->where(['userid'=>$p['publishuserid']])->one();
			Yii::error("activity add agent:".print_r($agent,1)."\n");
			Yii::error("activity add agent name:".$agent['nickname']."\n");


			$m->publishusername = $agent['nickname'];
			$m->publishusertags = $agent['tags'];
			$m->organization = $agent['organization'];
			$m->organizationauth = $p['organizationauth'];
			$m->headpic = $agent['picture'];
			// $m->organizationpic = $p['organizationpic'];
			$m->position = $agent['position'];
			$m->activitysubject = $p['activitysubject'];
			$m->activitytype = $p['activitytype'];
			$m->activitypic = $p['activitypic'];
			$m->fee = $p['fee'];
			$m->begintime = $p['begintime'];
			$m->endtime = $p['endtime'];
			$m->activitycity = $p['activitycity'];
			$m->location = $p['location'];
			$m->personcount = $p['personcount'];
			$m->activitydetail = $p['activitydetail'];
			$m->createtime = $m->updatetime = date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->activityid];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1,'message'=>$e->getMessage()];
		}
	}
	public function pcModify($p){
		try{
			$session = Yii::$app->session;
			$mid = $session->get('msgid');
			if($p['mid'] == $mid){
				return ['rscode'=>1];
			}else{
				$mid = $session->set('msgid',$jsonobj->mid);
			}
			if($m = static::find()->where(['publishuserid'=>$p['publishuserid'],'activityid'=>$p['activityid']])->one()){
				// $m->organizationauth = $p['organizationauth'];
				// $m->headpic = $agent['picture'];
				// $m->organizationpic = $p['organizationpic'];
				// $m->position = $agent['position'];
				$m->activitysubject = $p['activitysubject'];
				$m->activitytype = $p['activitytype'];
				$m->activitypic = $p['activitypic'];
				$m->fee = $p['fee'];
				$m->begintime = $p['begintime'];
				$m->endtime = $p['endtime'];
				// $m->activitycity = $p['activitycity'];
				$m->location = $p['location'];
				$m->personcount = $p['personcount'];
				$m->activitydetail = $p['activitydetail'];
				$m->updatetime = date('Y-m-d H:i:s',time());
				$m->save();
				return ['rscode'=>0,'id'=>$m->activityid];
			}else{
				return ['rscode'=>1];
			}
			
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1,'message'=>$e->getMessage()];
		}
	}
	public function pcAdd($p){
		try{
			$session = Yii::$app->session;
			$mid = $session->get('msgid');
			if($p['mid'] == $mid){
				return ['rscode'=>1];
			}else{
				$mid = $session->set('msgid',$jsonobj->mid);
			}
			$m = new static;

			$m->publishuserid = $p['publishuserid'];
			$m->publishusertype = $p['publishusertype'];
			$m->publishusername = $p['publishusername'];
			$m->organizationauth = $p['organizationauth'];
			// $m->headpic = $agent['picture'];
			// $m->organizationpic = $p['organizationpic'];
			// $m->position = $agent['position'];
			$m->activitysubject = $p['activitysubject'];
			$m->activitytype = $p['activitytype'];
			$m->activitypic = $p['activitypic'];
			$m->fee = $p['fee'];
			$m->begintime = $p['begintime'];
			$m->endtime = $p['endtime'];
			$m->activitycity = $p['activitycity'];
			$m->location = $p['location'];
			$m->personcount = $p['personcount'];
			$m->activitydetail = $p['activitydetail'];
			$m->createtime = $m->updatetime = date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->activityid];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1,'message'=>$e->getMessage()];
		}
	}
	public function updateActivity($p){
		try{
			$m = static::findOne($p['activityid']);
			if(!$m){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
			$m->publishuserid = $p['publishuserid'];
			// $m->publishusertype = $p['publishusertype'];
			// $m->publishusername = $p['publishusername'];
			// $m->publishusertags = $p['publishusertags'];
			// $m->organization = $p['organization'];
			// $m->headpic = $p['headpic'];
			// $m->organizationpic = $p['organizationpic'];
			// $m->position = $p['position'];
			$m->organizationauth = $p['organizationauth'];
			$m->activitysubject = $p['activitysubject'];
			$m->activitytype = $p['activitytype'];
			$m->activitypic = $p['activitypic'];
			$m->begintime = $p['begintime'];
			$m->endtime = $p['endtime'];
			$m->activitycity = $p['activitycity'];
			$m->location = $p['location'];
			$m->personcount = $p['personcount'];
			$m->activitydetail = $p['activitydetail'];
			$m->updatetime = date('Y-m-d H:i:s',time());
			$m->save();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	// public function deleteActivity($id){
	// 	try{
	// 		$m = static::findOne($id);
	// 		if(!$m){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
	// 		if(!$m->validflag){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
	// 		$m->validflag = 0;
	// 		$m->save();
	// 		return ['rscode'=>0];
	// 	}catch(\Exception $e) {
	// 		Yii::error($e->getMessage()."\n");
	// 		return ['rscode'=>1];
	// 	}
	// }

	public function deleteActivity($p){
		try{
			$m = static::findOne($p['activityid']);
			if(!$m){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'访问活动id不存在'];}
			$m->validflag = 0;
			$m->save();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}

	public function list($p){
		try{
			// foreach( $p as $k=>$v){
			// 	if(!$v)
			// 	{
			// 		unset($p[$k]);
			// 	}
			// }
			//$r = $this->select()->andWhere($p)->offset($p->start)->limit($p->count])->asArray()->all();
			//$r = $this->select()->orderBy('createtime DESC')->offset($p['start'])->limit($p['count'])->asArray()->all();
			//return ['rscode'=>0,'data'=>$r];


			 $connection = Yii::$app->db;

			$sql = sprintf("select * from (t_activity a left join t_activity_organization b on a.publishuserid = b.userid) order by a.createtime desc limit %s,%s", $p['start'],$p['count']);

			Yii::error("Activity::list sql is $sql\n");
			$command = $connection->createCommand($sql);
			$list = $command->queryAll();
			return ['rscode'=>0,'data'=>$list];
		} catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function listByUserid($p){
		try{

			$r = $this->selectDb()->andWhere(['publishuserid'=>$p['userid']])->offset($p['start'])->limit($p['count'])->asArray()->all();
			return ['rscode'=>0,'data'=>$r];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function detail($p){
		try{
			Yii::error("detail activityid:".$p['activityid']."\n");
			$r = $this->selectDb()->select('t_activity.activityid,t_activity.publishuserid,t_activity.publishusertype,t_activity.publishusername,t_activity.organizationauth,t_activity.activitysubject,t_activity.activitytype,t_activity.activitypic,t_activity.fee,t_activity.begintime,t_activity.endtime,t_activity.activitycity,t_activity.location,t_activity.personcount,t_activity.activitydetail,t_activity.createtime,t_activity.updatetime,t_user.picture as headpic,t_agent.position,t_agent.organization')->andwhere(['activityid'=>$p['activityid'],'publishuserid'=>$p['publishuserid']])->leftjoin('t_user','t_user.id = t_activity.publishuserid')->leftjoin('t_agent','t_agent.userid = t_activity.publishuserid')->asArray()->one();
			$m = ActivityOrg::find()->where(['userid'=>$p['publishuserid']])->asArray()->one();

			return ['rscode'=>0,'data'=>$r,'orginfo'=>$m];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1,'error'=>$e->getMessage()];
		}
	}

	private function selectDb(){
		return static::find()->where(['t_activity.validflag'=>1]);
	}
}

?>
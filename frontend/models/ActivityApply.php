<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;

class ActivityApply extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_activity_apply';
	}
	public function add($p){
		try{
			$m = new static;
			$m->activityid = $p['activityid'];
			$m->applyuserid = $p['applyuserid'];
			$m->createtime = date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->id];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function deleteApply($p){
		try{
			$m = static::find()->where(['applyuserid'=>$p['applyuserid'],'activityid'=>$p['activityid']])->one();
			if(!$m){return ['rscode'=>1,'msg'=>'您尚未报名该活动'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'您已退出该活动'];}
			$m->validflag=0;
			$m->save();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function listByUserid($p){
		try{
			//$r = static::find()->where(['validflag'=>1,'applyuserid'=>$p['userid'])->offset($p['start'])->limit($p['count'])->asArray()->all();
			//return ['rscode'=>0,'data'=>$r];
			$sql = sprintf("SELECT a.* FROM t_activity a ,t_activity_apply b where a.activityid=b.activityid and b.validflag=1 and a.validflag=1 and b.applyuserid=%s LIMIT %s,%s", $p['userid'], $p['start'], $p['count']);
            Yii::error("sql is ".$sql."\n");

            $connection = Yii::$app->db;
            $command = $connection->createCommand($sql);
            $list = $command->queryAll();

			//$r = static::find()->where(['validflag'=>1,'userid'=>$p['userid']])->offset($p['start'])->limit($p['count'])->asArray()->all();
			return ['rscode'=>0,'data'=>$list];

		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function listById($p){
		try{
			//$r = static::find()->where(['validflag'=>1,'activityid'=>$p['activityid']])->offset($p['start'])->limit($p['count'])->asArray()->all();
			//return ['rscode'=>0,'data'=>$r];
			$connection = Yii::$app->db;
			$sql = sprintf("SELECT count(*) as cnt FROM t_user a ,t_activity_apply b where a.id=b.applyuserid and b.validflag=1 and a.validflag=1 and b.activityid=%s", $p['activityid']);
            Yii::error("sql is ".$sql."\n");
			$command = $connection->createCommand($sql);
            $count = $command->queryAll();
            
            
			$sql = sprintf("SELECT a.id,a.picture,a.nickname,a.agentflag,a.phone,b.createtime FROM t_user a ,t_activity_apply b where a.id=b.applyuserid and b.validflag=1 and a.validflag=1 and b.activityid=%s LIMIT %s,%s", $p['activityid'], $p['start'], $p['count']);
            Yii::error("sql is ".$sql."\n");

            
            $command = $connection->createCommand($sql);
            $list = $command->queryAll();
			return ['rscode'=>0,'count'=>$count[0]['cnt'],'data'=>$list];
			
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function isApply($p){
		try{
			$m = static::find()->where(['applyuserid'=>$p['applyuserid'],'activityid'=>$p['activityid']])->one();
			if(!$m){return ['rscode'=>1,'msg'=>'您尚未报名该活动'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'您已退出该活动'];}
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
}

?>
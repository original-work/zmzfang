<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;

class ActivityComment extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_activity_comment';
	}
	public function add($p){
		try{
			$m = new static;
			$m->activityid = $p['activityid'];
			$m->userid = $p['userid'];
			$m->comment = $p['comment'];
			$m->createtime = date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->id];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function deleteComment($p){
		try{
			$m = static::find()->where(['activityid'=>$p['activityid'],'commentids'=>$p['id']])->one();
			if(!$m){return ['rscode'=>1,'msg'=>'此评论无效'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'此评论无效'];}
			$m->validflag=0;
			$m->save();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function list($p){
		try{
			//$r = static::find()->where(['validflag'=>1,'activityid'=>$p['activityid']])->offset($p['start'])->limit($p['count'])->asArray()->all();
			//return ['rscode'=>0,'data'=>$r];
			$connection = Yii::$app->db;
			$sql = sprintf("SELECT count(*) as cnt FROM t_user a ,t_activity_comment b where a.id=b.userid and b.validflag=1 and a.validflag=1 and b.activityid=%s", $p['activityid']);
            Yii::error("sql is ".$sql."\n");

            $command = $connection->createCommand($sql);
            $count = $command->queryAll();

			$sql = sprintf("SELECT a.id,a.picture,a.nickname,a.agentflag,b.activityid,b.comment,b.createtime FROM t_user a ,t_activity_comment b where a.id=b.userid and b.validflag=1 and a.validflag=1 and b.activityid=%s order by b.createtime desc LIMIT %s,%s", $p['activityid'], $p['start'], $p['count']);
            Yii::error("sql is ".$sql."\n");

            
            $command = $connection->createCommand($sql);
            $list = $command->queryAll();
			return ['rscode'=>0,'count'=>$count[0]['cnt'],'data'=>$list];

		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}

}

?>
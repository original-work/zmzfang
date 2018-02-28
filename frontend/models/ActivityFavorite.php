<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;

class ActivityFavorite extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_favorite_activity';
	}
	public function add($p){
		try{
			$m = new static;
			$m->activityid = $p['activityid'];
			$m->userid = $p['userid'];
			$m->createtime = date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->id];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}

	public function getFavoriteActivity($userid,$activityid)
    {
    		return static::findAll(['userid'=>$userid,'activityid'=>$activityid]);
    }

	public function deleteFavorite($p){
		try{

			try{
    				$reqlist=static::getFavoriteActivity($p['userid'],$p['activityid']);
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

			// $m = static::find()->where(['userid'=>$p['userid'],'activityid'=>$p['activityid']])->one();
			// if(!$m){return ['rscode'=>1];}
			// $m->validflag=0;
			// $m->save();
			// return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
	public function listByUserid($p){
		try{
			$sql = sprintf("SELECT a.* FROM t_activity a ,t_favorite_activity b where a.activityid=b.activityid and b.validflag=1 and a.validflag=1 and b.userid=%s LIMIT %s,%s", $p['userid'], $p['start'], $p['count']);
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
	public function isFav($p){
		try{
			$m = static::find()->where(['userid'=>$p['userid'],'activityid'=>$p['activityid']])->one();
			if(!$m){return ['rscode'=>1];}
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1];
		}
	}
}

?>
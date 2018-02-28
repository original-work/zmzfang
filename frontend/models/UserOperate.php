<?php 
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class UserOperate extends ActiveRecord
{
	public static function tableName()
    {
        return 't_user_operate';
    }
    // public static function getAgentBehaviour($obj){
    // 	return ['creditlist'=>[],'houselist'=>[],'statuslist'=>[],'modifyhouselist'=>[]];
    // }
    public static function addUserLog($obj){
    	$model = new static;
    	$model->userid    = $obj['userid'];
		$model->type      = $obj['type'];
		$model->dstid     = $obj['dstid'];
		$model->dstuserid = $obj['dstuserid'];
		$model->createtime = $model->updatetime = date('Y-m-d H:i:s');
		$model->validflag = 1;
        $model->city = $obj['city'];
		if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    public static function getBusinesscardStatistics($obj){
    	$visitcnt = static::find()->where(['dstuserid'=>$obj->userid,'validflag'=>1,'type'=>72])->count();
    	$contactmecnt = static::find()->where(['dstuserid'=>$obj->userid,'validflag'=>1,'type'=>80])->count();
    	return ['showbusinesscardcnt'=>0,'visitcnt'=>$visitcnt,'contactmecnt'=>$contactmecnt];
    }

    public static function getMyhouseStatistics($obj){
    	$visitcnt = static::find()->where(['dstuserid'=>$obj->userid,'validflag'=>1,'type'=>72])->count();
    	$contactmecnt = static::find()->where(['dstuserid'=>$obj->userid,'validflag'=>1,'type'=>80])->count();
    	return ['publishcnt'=>$publishcnt,'updaterate'=>0,'visitcnt'=>$visitcnt,'contactmecnt'=>$contactmecnt];
    }

    public static function GetAgentBehaviour($obj){
        Yii::error("obj is ".print_r($obj,1)."\n");
        $res = static::find()->select('type, createtime')->where(['userid'=>$obj->id,'validflag'=>1])->orderBy('createtime DESC')->limit(5)->asArray()->all();
        Yii::error("res is ".print_r($res,1)."\n");
        return $res;
    }


    // public static function GetWhoHaveSeenAgent($jsonData)
    // {
    //     $sql='select * from (select v_agent.userid,nickname,picture,sex,city,agentflag,logintime,tags,activeregion,organization,position,max(t_user_operate.updatetime) As updatetime from v_agent join t_user_operate on t_user_operate.userid=v_agent.userid where agentflag = 1  and v_agent.userid in (select distinct t_user_operate.userid from t_user_operate where type=73 and dstid='.$jsonData->dstid.') group by v_agent.userid order by updatetime desc) as t_table limit '.$jsonData->start.','.$jsonData->count;
    //     Yii::error("GetWhoHaveSeenAgent: ".$sql);
    //     return static::findBySql($sql)->asArray()->all();
    // }


    public static function GetWhoHaveSeenAgent($jsonData)
    {
        $sql='select p2.userid,p2.updatetime,nickname,picture,organization,position,agentflag from t_user p1
            join
            (select userid,max(t_user_operate.updatetime) updatetime from t_user_operate where type=73 and dstid='.$jsonData->dstid.' group by userid) p2 
            on p1.id=p2.userid 
            left join
            (select userid,organization,position from t_agent) p3
            on p1.id=p3.userid 
            order by updatetime desc 
            limit '.$jsonData->start.','.$jsonData->count;
        Yii::error("GetWhoHaveSeenAgent: ".$sql);
        return static::findBySql($sql)->asArray()->all();
    }


    public static function GetWhoHaveSeenAgentToday($jsonData)
    {
        return static::find()->where('type=73 and TO_DAYS(createtime) = TO_DAYS(NOW()) and dstid='.intval($jsonData->dstid))->groupby('userid')->count();
    }
}
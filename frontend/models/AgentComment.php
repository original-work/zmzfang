<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class AgentComment extends ActiveRecord
{
    public static function tableName()
    {
        return 't_comment';
    }
    public static function getComment($obj){
    	retrun static::find()->leftJoin('t_user','t_comment.userid = t_user.id')->where(['type'=>$obj->type,'dstid'=>$obj->dstid,'validflag'=>1])->asArray()->limit($obj->count)->offset($obj->start)->all();
    }

    public static function addComment($obj){
    	$model = new static;
    	$model->type      = $obj->type;
    	$model->dstid     = $obj->dstid;
    	$model->userid    = $obj->userid;
    	$model->comment   = $obj->comment;
    	$model->praisecnt = $obj->praisecnt;
    	$model->createtime =  $model->updatetime = date('Y-m-d H:i:s');
    	$model->validflag = 1;
    	if($obj->type == 1){
    		$agent = new \frontend\models\Agent();
    		$agent-> praisecnt+=$model->praisecnt;
    		$agent->save();
    	}elseif($obj->type == 2){
    		$expert = new \frontend\models\expert();
    		$expert->praisecnt+=$model->praisecnt;
    		$expert->save();
    	}
    	if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }

    public static function deleteComment($obj){
    	$commentid = $obj->commentid;
    	$model = static::updateAll(['validflag' => -1],['type'=>$obj->type,'dstid'=>$obj->dstid,id=>$commentid,'validflag'=>1]);
    }
}
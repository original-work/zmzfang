<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class HelpReply extends ActiveRecord
{
	public static function tableName()
    {
        return 't_help_reply';
    }
    static function getHelpReplyList($jsonObj){
        $sql='SELECT t_help_reply.*, t_user.nickname, t_user.picture,t_user.agentflag FROM t_help_reply JOIN t_user ON t_help_reply.replyuserid=t_user.id WHERE t_help_reply.helpid='.$jsonObj->helpid.' order by updatetime desc';
        Yii::error("getHelpReplyList: ".$sql);
        return static::findBySql($sql)->asArray()->all();
    }
    static function replyHelp($jsonObj){
        Yii::error("replyHelp:jsonObj is ".print_r($jsonObj,1)."\n");
    	$model = new static;
    	$model->helpid = 	  $jsonObj->helpid;
    	$model->helpuserid =  $jsonObj->helpuserid;
    	$model->replyuserid = $jsonObj->replyuserid;
    	$model->replydetail = $jsonObj->replydetail;
    	$model->praisecnt =   0;
    	$model->createtime = $model->updatetime = date('Y-m-d H:i:s',time());
    	$model->validflag =   1;
    	if($model->save()){
            $help = \frontend\models\ForHelp::findOne($jsonObj->helpid);
            $help->replycnt+=1;
            $help->save();
            return ['rscode'=>0,'replyid'=>$model->replyid];
        }else{
            return ['rscode'=>1];
        }
    }
    static function addHelpReplyPraise($jsonObj){
        Yii::error("addHelpReplyPraise:jsonObj is ".print_r($jsonObj,1)."\n");
    	$model= static::findOne($jsonObj->replyid);
    	$model->praisecnt += 1;
    	if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    static function delHelpReplyPraise($jsonObj){
        Yii::error("delHelpReplyPraise:jsonObj is ".print_r($jsonObj,1)."\n");
        $model= static::findOne($jsonObj->replyid);
        $model->praisecnt -= 1;
        if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    static function addNegative($jsonObj){
        Yii::error("addNegative:jsonObj is ".print_r($jsonObj,1)."\n");
        $model= static::findOne($jsonObj->replyid);
        $model->negativecnt += 1;
        if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    static function delNegative($jsonObj){
        Yii::error("delNegative:jsonObj is ".print_r($jsonObj,1)."\n");
        $model= static::findOne($jsonObj->replyid);
        $model->negativecnt -= 1;
        if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    public static function getBestReply($jsonObj){
        Yii::error("getBestReply:jsonObj is ".print_r($jsonObj,1)."\n");
         $sql='SELECT t_help_reply.*, t_user.nickname, t_user.picture,t_user.agentflag FROM (t_help_reply JOIN t_requirement_help ON t_help_reply.replyid=t_requirement_help.adoptedreplyid) JOIN t_user ON t_user.id=t_help_reply.replyuserid WHERE t_help_reply.helpid='.$jsonObj->helpid;
        Yii::error("getBestReply: ".$sql);
        return static::findBySql($sql)->asArray()->one();
    }

}
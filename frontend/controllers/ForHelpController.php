<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ForHelp;
use frontend\models\HelpReply;
use frontend\models\UserOperate;
use yii\helpers\Json;

class ForHelpController extends Controller
{
	public $enableCsrfValidation = false;
	function actionAddHelp(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::addHelp($obj);
    	if(0 == $res['rscode'])
        {
            $options['userid'] = $obj->publishuserid;
            $options['type'] = 60;
            $options['dstid'] = $res['helpid'];
            $options['dstuserid'] = 0;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }

        return Json::encode($res);
	}

    function actionReplyFee(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ForHelp::replyFee($obj);
        return Json::encode($res);
    }

	function actionModifyHelp(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::modifyHelp($obj);
    	if(0 == $res['rscode'])
        {
            $options['userid'] = $obj->publishuserid;
            $options['type'] = 61;
            $options['dstid'] = $obj->helpid;
            $options['dstuserid'] = 0;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }
        return Json::encode($res);
	}
	function actionGetHelpList(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::getHelpList($obj);
        return Json::encode($res);
	}
	function actionGetHelpListByUserid(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::getHelpListByUserid($obj);
        return Json::encode($res);
	}
	function actionGetHelpDetail(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::getHelpDetail($obj);
    	if(!empty($obj->userid))
        {
            $options['userid'] = $obj->userid;
            $options['type'] = 63;
            $options['dstid'] = $obj->helpid;
            $options['dstuserid'] = $res['publishuserid'];
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }
        return Json::encode($res);
	}
	function actionReplyHelp(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::replyHelp($obj);
    	if(!empty($obj->userid))
        {
            $options['userid'] = $obj->replyuserid;
            $options['type'] = 62;
            $options['dstid'] = $obj->helpid;
            $options['dstuserid'] = $obj->helpuserid;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }
        return Json::encode($res);
	}
	function actionGetHelpReplyList(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::getHelpReplyList($obj);
        return Json::encode($res);
	}
	function actionAddHelpReplyPraise(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::addHelpReplyPraise($obj);
        return Json::encode($res);
	}
	function actionDeleteHelp(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::deleteHelp($obj);
        return Json::encode($res);
	}
	function actionAcceptHelpReply(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=ForHelp::acceptHelpReply($obj);
        return Json::encode($res);
	}
	function actionGetBestReply(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::getBestReply($obj);
        return Json::encode($res);
	}
	function actionAddNegative(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::addNegative($obj);
        return Json::encode($res);
	}
	function actionDelHelpReplyPraise(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::delHelpReplyPraise($obj);
        return Json::encode($res);
	}
	function actionDelNegative(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=HelpReply::delNegative($obj);
        return Json::encode($res);
	}

    function actionPushHelp(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ForHelp::pushHelp($obj);
        return Json::encode($res);
    }
}
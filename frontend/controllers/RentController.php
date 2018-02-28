<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Rent;
use frontend\models\UserOperate;
use yii\helpers\Json;

class RentController extends Controller
{
	public $enableCsrfValidation = false;
	function actionAddRent(){
		$data=Yii::$app->request->rawBody;//获取AJAX传参（JSON格式）
    	$obj = json_decode($data);//把获取的传参转化成对象
    	$res=Rent::addRent($obj);
        if(0 == $res['rscode'])
        {
            $options['userid'] = $obj->publishuserid;
            $options['type'] = 50;
            $options['dstid'] = $res['id'];
            $options['dstuserid'] = 0;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }

        return Json::encode($res);
	}
	function actionGetRentList(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::getRentList($obj);
        return Json::encode($res);
	}
	function actionGetRentListByUserid(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::getRentListByUserid($obj);
        return Json::encode($res);
	}
	function actionGetRentDetail(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::getRentDetail($obj);
        if(!empty($obj->userid))
        {
            $options['userid'] = $obj->userid;
            $options['type'] = 53;
            $options['dstid'] = $obj->rentid;
            $options['dstuserid'] = $res['publishuserid'];
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }

        return Json::encode($res);
	}
	function actionUpdateRent(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::updateRent($obj);
        if(0 == $res['rscode'])
        {
            $options['userid'] = $obj->publishuserid;
            $options['type'] = 51;
            $options['dstid'] = $obj->rentid;
            $options['dstuserid'] = 0;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }
        return Json::encode($res);
	}
	function actionDeleteRent(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::deleteRent($obj);
        return Json::encode($res);
	}
	function actionGetBidinfoByRentid(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::getBidinfoByRentid($obj);
        return Json::encode($res);
	}
	function actionBidRent(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::bidRent($obj);
        return Json::encode($res);
	}
	function actionFlushRentRequirement(){
		$data=Yii::$app->request->rawBody;
    	$obj = json_decode($data);
    	$res=Rent::flushRentRequirement($obj);
        return Json::encode($res);
	}
	public function actionPushRent(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Rent::PushRent($obj);
        return json_encode($res);
    }
}
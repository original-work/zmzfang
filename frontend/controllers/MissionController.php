<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Mission;


class MissionController extends Controller
{
	public $enableCsrfValidation = false;
	
	public function actionGetMissionInfo()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::getMissionInfo($obj);
		return json_encode($info);
	}
	public function actionSetMissionInfo()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::setMissionInfo($obj);
		return json_encode($info);
	}
	public function actionGetReward()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::getReward($obj);
		return json_encode($info);
	}
	public function actionGetRewardAgent()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::getRewardAgent($obj);
		return json_encode($info);
	}
	public function actionReward()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::reward($obj);
		return json_encode($info);
	}
	public function actionPushInvite()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$info=Mission::pushInvite($obj);
		return json_encode($info);
	}
	public function actionSort()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$m=new \frontend\models\Reward();
		$info = $m->getSort($obj);
		return json_encode($info);
	}
	public function actionSortList()
	{
		$m=new \frontend\models\Reward();
		$info = $m->list($obj);
		return json_encode($info);
	}
}

?>

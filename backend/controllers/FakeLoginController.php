<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\helpers\Json;

class FakeLoginController extends BaseController
{
    public $layout = "lte_main";
	public $enableCsrfValidation = false;
	public function actionIndex()
	{
		$phone = intval(Yii::$app->request->post('phone'));
		$userid = intval(Yii::$app->request->post('userid'));
		$info='';
		if($phone){
			$info = User::findOne(['phone'=>$phone]);
		}
		if($userid){
			$info = User::findOne(['id'=>$userid]);
		}
		return $this->render('index',['info' => $info,'phone'=>$phone,'userid'=>$userid]);
	}
}
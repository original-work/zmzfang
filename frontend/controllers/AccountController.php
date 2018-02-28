<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Account;


class AccountController extends Controller
{
		public $enableCsrfValidation = false;
	

	    public function actionGetAccount()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Account::GetAccount($obj);
	        return json_encode($res);
	    }

	    public function actionGetAccountDetail()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Account::GetAccountDetail($obj);
	        return json_encode($res);
	    }

	    public function actionApplyDrawed()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Account::ApplyDrawed($obj);
	        return json_encode($res);
	    }

	    public function actionPayUseZmzfangaccount()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Account::PayUseZmzfangaccount($obj);
	        return json_encode($res);
	    }

	    public function actionGetApplyDrawedList()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Account::GetApplyDrawedList($obj);
	        return json_encode($res);
	    }
}
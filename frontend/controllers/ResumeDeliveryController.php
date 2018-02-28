<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ResumeDelivery;


class ResumeDeliveryController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddDelivery()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeDelivery::addDelivery($obj);
        return json_encode($res);
    }

    public function actionModifyDelivery()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeDelivery::modifyDelivery($obj);
        return json_encode($res);
    }

    public function actionGetDelivery()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeDelivery::getDelivery($obj);
        return json_encode($res);
    }

    public function actionIsDelivery()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeDelivery::IsDelivery($obj);
        return json_encode($res);
    }


}

?>
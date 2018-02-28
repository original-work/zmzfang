<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ResumeWork;


class ResumeWorkController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddResumeWork()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeWork::addResumeWork($obj);
        return json_encode($res);
    }

    public function actionModifyResumeWork()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeWork::modifyResumeWork($obj);
        return json_encode($res);
    }

    public function actionDeleteResumeWork()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeWork::deleteResumeWork($obj);
        return json_encode($res);
    }

    public function actionGetResumeWork()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeWork::getResumeWork($obj);
        return json_encode($res);
    }

    public function actionGetResumeWorkList()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeWork::getResumeWorkList($obj);
        return json_encode($res);
    }

}

?>
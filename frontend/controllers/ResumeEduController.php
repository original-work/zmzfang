<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ResumeEdu;


class ResumeEduController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddResumeEdu()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeEdu::addResumeEdu($obj);
        return json_encode($res);
    }

    public function actionModifyResumeEdu()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeEdu::modifyResumeEdu($obj);
        return json_encode($res);
    }

    public function actionDeleteResumeEdu()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeEdu::deleteResumeEdu($obj);
        return json_encode($res);
    }

    public function actionGetResumeEdu()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeEdu::getResumeEdu($obj);
        return json_encode($res);
    }

    public function actionGetResumeEduList()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResumeEdu::getResumeEduList($obj);
        return json_encode($res);
    }

}

?>
<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Answer;
use frontend\models\PayQuestion;


class AnswerController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionGetAnswer()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::getAnswer($obj);
        return json_encode($res);
    }

    public function actionGetAnswerList()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::getAnswerList($obj);
        return json_encode($res);
    }

    public function actionListenAnswer()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=PayQuestion::listenAnswer($obj);
        return json_encode($res);
    }

    public function actionModifyPayQuestionOrderStatus()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=PayQuestion::modifyPayQuestionOrderStatus($obj);
        return json_encode($res);
    }

    public function actionModifyListenCnt()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::modifyListenCnt($obj);
        return json_encode($res);
    }

    public function actionAskQuestionOnline()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::askQuestionOnline($obj);
        return json_encode($res);
    }

    public function actionGetQuestionById()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::getQuestionById($obj);
        return json_encode($res);
    }

    public function actionUpdateQuestionAnswer()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Answer::UpdateQuestionAnswer($obj);
        return json_encode($res);
    }

    public function actionGetPayQuestion()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=PayQuestion::GetPayQuestion($obj);
        return json_encode($res);
    }

}

?>    







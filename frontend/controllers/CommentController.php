<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Comment;

class CommentController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex($userid)
    {
        header("Content-type:json/application;charset=utf-8");
        $model = new Area();
    

    }

    public function actionGetComment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Comment::GetComment($obj);
        return json_encode($res);
    }

    public function actionAddComment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Comment::AddComment($obj);
        return json_encode($res);
    }

    public function actionDeleteComment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Comment::DeleteComment($obj);
        return json_encode($res);
    }

}

?>

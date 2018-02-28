<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Expert;
use frontend\models\FavoriteExpert;

class ExpertController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::addExpert($obj);
        return json_encode($res);
    }

    public function actionModifyExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::modifyExpert($obj);
        return json_encode($res);
    }

    public function actionGetExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::getExpert($obj);
        return json_encode($res);
    }

    public function actionGetExpertDetail()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::getExpertDetail($obj);
        return json_encode($res);
    }

    public function actionGetExpertList()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::getExpertList($obj);
        return json_encode($res);
    }

    public function actionAddFavoriteExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoriteExpert::addFavoriteExpert($obj);
        return json_encode($res);
    }

    public function actionGetFavoriteExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoriteExpert::getFavoriteExpert($obj);
        return json_encode($res);
    }

    public function actionDeleteFavoriteExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoriteExpert::deleteFavoriteExpert($obj);
        return json_encode($res);
    }

    public function actionIsFavoriteExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoriteExpert::isFavoriteExpert($obj);
        return json_encode($res);
    }
    public function actionSearchExpertAndQuestion()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::searchExpertAndQuestion($obj);
        return json_encode($res);
    }

    public function actionAddPraise()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Expert::addPraiseCnt($obj);
        return json_encode($res);
    }
}

?>
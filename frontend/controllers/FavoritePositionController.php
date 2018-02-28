<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\FavoritePosition;


class FavoritePositionController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddFavoritePosition()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoritePosition::AddFavoritePosition($obj);
        return json_encode($res);
    }

    public function actionGetFavoritePosition()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoritePosition::GetFavoritePosition($obj);
        return json_encode($res);
    }

    public function actionDeleteFavoritePosition()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoritePosition::DeleteFavoritePosition($obj);
        return json_encode($res);
    }

    public function actionIsFavoritePosition()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoritePosition::IsFavoritePosition($obj);
        return json_encode($res);
    }
}

?>
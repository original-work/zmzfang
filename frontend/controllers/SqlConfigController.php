<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Config;

class SqlConfigController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionGetSearchParams()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Config::getSearchParams($obj);
        return json_encode($res);
    }

}

?>

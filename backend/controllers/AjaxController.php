<?php

namespace backend\controllers;

use Yii;
use common\helpers\Functions;
use yii\web\Controller;
use backend\models\School;

class AjaxController extends Controller
{
    
    public function actionNum()
    {
        $model = new School();
        $count = $model::find()->where(["region"=>$_GET['val']])->count();
        //$count = $count<10?"0".$count:$count;
        return $count;
    }
    
}

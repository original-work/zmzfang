<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Area;
use frontend\models\Metro;
use frontend\models\School;
use frontend\models\ResidentialInfo;
use frontend\models\SchoolCity;

class AreaController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex($userid)
    {
        header("Content-type:json/application;charset=utf-8");
        $model = new Area();
    

    }

    public function actionGetAreaInfo()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Area::GetAreaInfo($obj);
        return json_encode($res);
    }

    public function actionGetMetroInfo()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Metro::GetMetroInfo($obj);
        return json_encode($res);
    }

    public function actionGetSchoolInfo()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=School::GetSchoolInfo($obj);
        return json_encode($res);
    }

    public function actionGetDistrictMatch()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=ResidentialInfo::GetDistrictMatch($obj);
        return json_encode($res);
    }

    public function actionGetSchoolMatch()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=SchoolCity::GetSchoolMatch($obj);
        return json_encode($res);
    }

}

?>

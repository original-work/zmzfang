<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Report;


class ReportController extends Controller
{
		public $enableCsrfValidation = false;
		
	    public function actionAddReport()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Report::AddReport($obj);
	        return json_encode($res);
	    }


	    public function actionReportFalseInfo()
	    {
	    	Yii::error("actionReportFalseInfo\n");
	        $data=Yii::$app->request->rawBody;
	        $res=ReportPicture::SubmitPicture($data);
	        return json_encode($res);
	    }
}

?>
<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Advertisement;


class PromotionController extends Controller
{
		public $enableCsrfValidation = false;
	
		public function actionGetAdvertisement()
		{
			 	$data=Yii::$app->request->rawBody;
    	 	$obj = json_decode($data);
			 	$ads=Advertisement::getAdvertisement($obj->locationid);
			 	if(empty($ads)){
    				return 'null';
    	 	}
    		return json_encode($ads);
		}
		
		public function actionGetAdvertisementDetail()
		{
				$data=Yii::$app->request->rawBody;
    	 		$obj = json_decode($data);
    	 		$ads=Advertisement::getAdvertisementDetail($obj->advertisementid);
			 	if(empty($ads)){
    				return 'null';
    	 		}
    			return json_encode($ads);
		}
}
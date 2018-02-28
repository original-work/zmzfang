<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Bid;


class BidController extends Controller
{
		public $enableCsrfValidation = false;
	
		public function actionGetBidByRequirementid()
		{
			 	$data=Yii::$app->request->rawBody;
    	 		$obj = json_decode($data);
			 	$retstr=Bid::GetBidByRequirement($obj->requirementid,isset($obj->limitflag),$obj->city);
			 	if(empty($retstr)){
    				return 'null';
    	 	}
    		return json_encode($retstr);
		}

		public function actionGetBidByHouseid()
		{
			 	$data=Yii::$app->request->rawBody;
    	 		$obj = json_decode($data);
			 	$retstr=Bid::GetBidByHouse($obj->houseid,isset($obj->limitflag));
			 	if(empty($retstr)){
    				return 'null';
    	 	}
    		return json_encode($retstr);
		}
		
		public function actionModifyBidStatus()
		{
				$data=Yii::$app->request->rawBody;
    	 		$obj = json_decode($data);
			 	$retstr=Bid::modifyBidStatus($obj);
			 	return json_encode($retstr);
		}

		public function actionGetSpecificHouseBidInfo()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Bid::GetSpecificHouseBidInfo($obj);
	        return json_encode($res);
	    }


	    public function actionDoBid()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Bid::DoBid($obj);
	        return json_encode($res);
	    }
}
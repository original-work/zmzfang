<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Search;


class SearchController extends Controller
{
		public $enableCsrfValidation = false;
	

	    public function actionSearchRequirement()
	    {
	        $data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Search::searchRequirement($obj);
	        return json_encode($res);
	    }
	    public function actionSearchRequirementIndex(){
	    	$data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Search::searchRequirementIndex($obj);
	        return json_encode($res);
	    }

 		public function actionSearchRequirementLastest(){
	    	$data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Search::searchRequirementLastest($obj);
	        return json_encode($res);
	    }

	    public function actionSearchAgent(){
	    	$data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Search::searchAgent($obj);
	        return json_encode($res);
	    }
	    public function actionSearchAgentByTag(){
	    	$data=Yii::$app->request->rawBody;
	        $obj = json_decode($data);
	        $res=Search::SearchAgentByTag($obj);
	        return json_encode($res);
	    }
	    public function actionSearcht(){
	    	$data=Yii::$app->request->get();
	        $res=Search::searcht($data);
	        return json_encode($res);
	    }

}
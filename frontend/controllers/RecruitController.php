<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Recruit;


class RecruitController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionAddRecruit()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);

		//$res=Recruit::addRecruit($obj);
		$m= new Recruit();
		$res = $m->addRecruit($obj);
		return json_encode($res);
	}

	public function actionModifyRecruit()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::modifyRecruit($obj);
		return json_encode($res);
	}

	public function actionDeleteRecruit()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::deleteRecruit($obj);
		return json_encode($res);
	}
  
	public function actionGetRecruitList()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::getRecruitList($obj);
		return json_encode($res);
	}

	public function actionGetRecruitListByUserid()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::getRecruitListByUserid($obj);
		return json_encode($res);
	}

	
	public function actionGetRecruitCountByUserid()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::getRecruitCountByUserid($obj);
		return json_encode($res);
	}



	public function actionGetMyRecruitList()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::GetMyRecruitList($obj);
		return json_encode($res);
	}

	public function actionGetRecruitDetail()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::GetRecruitDetail($obj);
		return json_encode($res);
	}

	public function actionGetRecruitListByRecommend()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Recruit::GetRecruitListByRecommend($obj);
		return json_encode($res);
	}
	public function actionLimit()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$m= new Recruit();
		if($m->limit($obj)){
			return json_encode(['rscode'=>0]);
		}else{
			return json_encode(['rscode'=>1]);
		}
	}
}

?>
<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Activity;
use frontend\models\ActivityApply;
use frontend\models\ActivityComment;
use frontend\models\ActivityFavorite;
use frontend\models\ActivityOrg;
class ActivityController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionAddActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->add($p));
	}
	public function actionPcAdd(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->pcAdd($p));
	}
	public function actionPcModify(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->pcModify($p));
	}
	public function actionModifyActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->updateActivity($p));
	}
	// public function actionDeleteActivity($id){
	// 	$m = new Activity();
	// 	return json_encode($m->deleteActivity($id));
	// }

	public function actionDeleteActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->deleteActivity($p));
	}

	public function actionGetActivityList(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->list($p));
	}
	public function actionGetActivityListByUserid(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->listByUserid($p));
	}
	public function actionGetActivityDetail(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new Activity();
		return json_encode($m->detail($p));
	}
	public function actionAddActivityApply(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityApply();
		return json_encode($m->add($p));
	}
	public function actionDeleteActivityApply(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityApply();
		return json_encode($m->deleteApply($p));
	}
	public function actionGetActivityListByApplyUserid(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityApply();
		return json_encode($m->listByUserid($p));
	}
	public function actionGetApplyUserlistByActivityid(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityApply();
		return json_encode($m->listById($p));
	}
	public function actionIsActivityApply(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityApply();
		return json_encode($m->isApply($p));
	}
	public function actionAddFavoriteActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityFavorite();
		return json_encode($m->add($p));
	}
	public function actionGetFavoriteActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityFavorite();
		return json_encode($m->listByUserid($p));
	}
	public function actionDeleteFavoriteActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityFavorite();
		return json_encode($m->deleteFavorite($p));
	}
	public function actionIsFavoriteActivity(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityFavorite();
		return json_encode($m->isFav($p));
	}
	public function actionGetActivityComment(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityComment();
		return json_encode($m->list($p));
	}
	public function actionAddActivityComment(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityComment();
		return json_encode($m->add($p));
	}
	public function actionGetActivityOrg(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityOrg();
		return json_encode($m->detail($p));
	}
	public function actionAddActivityOrg(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityOrg();
		return json_encode($m->add($p));
	}
	public function actionModifyActivityOrg(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityOrg();
		return json_encode($m->modify($p));
	}
	public function actionDeleteActivityOrg(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityOrg();
		return json_encode($m->dele($p));
	}

	function actionActivityPicUpload(){
		$base64 = $_POST['base64'];	
		$s = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64));
		$rand = rand(1000, 9999);
		$res['picname'] = date("YmdHis",time()) . $rand .'.jpg';
		$res['status'] = file_put_contents("../web/weixin/img/activity/".$res['picname'], $s);

		return json_encode($res);
	}

	public function actionAddOrg(){
		$j = Yii::$app->request->rawBody;
		$p = json_decode($j,true);
		$m = new ActivityOrg();
		return json_encode($m->pcAdd($p));
	}
}
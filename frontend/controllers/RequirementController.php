<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Requirement;
use frontend\models\FavoriteRequirement;
use frontend\models\UserOperate;
use yii\helpers\Json;
use common\helpers\Functions;

class RequirementController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex($id,$userid = null){
        $model = new Requirement();
        $res = $model->getNeeds($id);
        
        if($res != null && $userid != null)
        {
            $options['userid'] = $userid;
            $options['type'] = 43;
            $options['dstid'] = $id;
            $options['dstuserid'] = $res['publishuserid'];

            UserOperate::addUserLog($options);
        }
        $res = is_null($res)?['rescode'=>1]:Functions::setData($res);
        echo Json::encode($res);
    }

    public function actionGetNewLists($limit,$areaid = null,$price = null, $housetype = null){
        $model = new Requirement();
        $res = $model->getNewLists($limit,$areaid,$price,$housetype);
        $res = is_null($res)?['rescode'=>1]:Functions::setData($res);
        echo Json::encode($res);
    }
    public function actionSubmit($id = null){
        $model = new Requirement();
        // $request = Yii::$app->request;
        // $id = $request->get('id');
        $res = $model->Submit($id);
        $res = $res?['rescode'=>1]:['rescode'=>0];
        echo Json::encode($res);
    }
    public function actionMyNeeds($userid){
        $model = new Requirement();
        $res = $model -> getMyNeeds($userid);
        $res = is_null($res)?['rescode'=>1]:Functions::setData($res);
        echo Json::encode($res);
    }
    
    public function actionGetRequirementList(){
    		$data=Yii::$app->request->rawBody;
    	 	$obj = json_decode($data);
    	 	$reqlist=Requirement::getRequirementList($obj);
			 	if(empty($reqlist)){
    				return 'null';
    	 	}
    		return json_encode($reqlist);
    }
    
    public function actionAddRequirement(){
    		$data=Yii::$app->request->rawBody;
    	 	$obj = json_decode($data);

             $reqlist=Requirement::addRequirement($obj);
             
            // if($obj->city == '上海市')
            // {
            //     $reqlist=Requirement::addRequirement($obj);
            // }
            // else
            // {
            //     $reqlist=Requirement::addRequirementByCity($obj);
            // }

            if(0 == $reqlist['rscode'])
            {
                $options['userid'] = $obj->publishuserid;
                $options['type'] = 40;
                $options['dstid'] = $reqlist['id'];
                $options['dstuserid'] = 0;
                $options['city'] = empty($obj->city)?'上海市':$obj->city;

                UserOperate::addUserLog($options);
            }
    		return json_encode($reqlist);
    }
    
    public function actionGetRequirementByuserid(){
    		$data=Yii::$app->request->rawBody;
    	 	$obj = json_decode($data);
    	 	$reqlist=Requirement::getUserRequirements($obj->userid);
			 	if(empty($reqlist)){
    				return 'null';
    	 	}
    		return json_encode($reqlist);
    }
    
    public function actionModifyRequirement(){
    		$data=Yii::$app->request->rawBody;
    	 	$obj = json_decode($data);
    	 	$reqlist=Requirement::modifyRequirement($obj);
            if(0 == $reqlist['rscode'])
            {
                $options['userid'] = $obj->publishuserid;
                $options['type'] = 41;
                $options['dstid'] = $obj->publishuserid;
                $options['dstuserid'] = 0;
                $options['city'] = empty($obj->city)?'上海市':$obj->city;
                UserOperate::addUserLog($options);
            }

    		return json_encode($reqlist);
    }


    public function actionSearch()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Requirement::Search($obj);
        return json_encode($res);
    }

    public function actionGetRequirementByDistrictid()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Requirement::GetRequirementByDistrictid($obj);
        if(empty($res)){
                return 'null';
        }
        return json_encode($res);
    }

    public function actionDelRequirementByRequirementid()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Requirement::DelRequirementByRequirementid($obj);
        return json_encode($res);
    }

    public function actionUpdateRequirementTime()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Requirement::UpdateRequirementTime($obj);
        if(0 == $res['rscode'])
        {
            $options['userid'] = $obj->userid;
            $options['type'] = 41;
            $options['dstid'] = $obj->requirementid;
            $options['dstuserid'] = $obj->userid;
            $options['city'] = empty($obj->city)?'上海市':$obj->city;
            UserOperate::addUserLog($options);
        }

        return json_encode($res);
    }

    public function actionIsFavoriteRequirement()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=FavoriteRequirement::isFavoriteRequirement($obj);
        return json_encode($res);
    }

    public function actionGetRecommendRequirement(){
        $data=Yii::$app->request->post('houseid');
        $model = new Requirement();
        $res = $model->getRecommendRequirement($data);
        return json_encode($res);
    }

    public function actionPushRequirement(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Requirement::PushRequirement($obj);
        return json_encode($res);
    }

    public function actionYdSet(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::set($obj);
        return json_encode($res);
    }
    public function actionYdGet(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::get($obj);
        return json_encode($res);
    }
    public function actionYdDetail(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::detail($obj);
        return json_encode($res);
    }
    public function actionYdGetListByUserid(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::getListByUserId($obj);
        return json_encode($res);
    }
    
    public function actionYdDelete(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::DelRequirementByRequirementid($obj);
        return json_encode($res);
    }

    public function actionYdSearchRequirementLastest(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdRequirement::searchRequirementLastest($obj);
        return json_encode($res);
    }
}
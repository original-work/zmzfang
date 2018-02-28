<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Advise;
use frontend\models\Supplyment;
use frontend\models\Requirement;
use frontend\models\HotKey;
use frontend\models\WeiXinPic;
use frontend\models\Agent;
use frontend\models\UserOperate;
use frontend\models\AgentComment;


class UserController extends Controller
{
	public $enableCsrfValidation = false;
	
	public function actionIndex($userid)
	{
		header("Content-type:json/application;charset=utf-8");
		$model = new User();
	}
	public function actionUserInfos(){
		$data=Yii::$app->request->post('users');
		$suerinfo=User::userInfos($data);
		return json_encode($suerinfo);
	}
	public function actionUserInfo(){
		$data=Yii::$app->request->rawBody;
		// var_dump($data);
		$obj = json_decode($data);
		$suerinfo=User::userInfo($obj);
		return json_encode($suerinfo);
	}
	public function actionGetUserInfo()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$suerinfo=User::getUserInfo($obj->userid);
		if(empty($suerinfo)){
			return 'null';
		}

		if(!empty($obj->loginuserid) && $obj->loginuserid != $obj->userid)
		{
			$options['userid'] = $obj->loginuserid;
			$options['type'] = 73;
			$options['dstid'] = $obj->userid;
			$options['dstuserid'] = $obj->userid;
			$options['city'] = empty($obj->city)?'上海市':$obj->city;
			UserOperate::addUserLog($options);
		}
		return json_encode($suerinfo);
	}
	
	public function actionGetUserByOpenid()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$userinfo=User::getUserByOpenid($obj->openid);
		if(empty($userinfo)){
			return 'null';
		}
		return json_encode($userinfo);
	}

	public function actionGetWhoHaveSeenAgent()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$userinfo=UserOperate::getWhoHaveSeenAgent($obj);
		if(empty($userinfo)){
			return 'null';
		}
		return json_encode($userinfo);
	}

	public function actionGetWhoHaveSeenAgentToday()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$userinfo=UserOperate::getWhoHaveSeenAgentToday($obj);
		if(empty($userinfo)){
			return 'null';
		}
		return json_encode($userinfo);
	}
	
	public function actionModifyUserInfo()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$suerinfo=User::modifyUserInfo($obj);
		if(0 == $res['rscode'])
		{
			$options['userid'] = $obj->userid;
			$options['type'] = 71;
			$options['dstid'] = $obj->userid;
			$options['dstuserid'] = 0;
			$options['city'] = empty($obj->city)?'上海市':$obj->city;
			UserOperate::addUserLog($options);
		}
		return json_encode($suerinfo);
	}
	
	public function actionGetFavoriteRequirement()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$retstr=User::getFavoriteRequirement($obj->userid);
		if(empty($retstr)){
			return 'null';
		}
		return json_encode($retstr);
	}
	
	public function actionDeleteFavoriteRequirement()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$suerinfo=User::deleteFavoriteRequirement($obj);
		return json_encode($suerinfo);
	}
	
	public function actionSubmitAdvise()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$suerinfo=Advise::submitAdvise($obj);
		return json_encode($suerinfo);
	}

	public function actionAddFavoriteRequirement()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$suerinfo=User::addFavoriteRequirement($obj);
		return json_encode($suerinfo);
	}


	public function actionPublishHouse()
	{
		$data=Yii::$app->request->rawBody;
		$res=User::publishHouse($data);
		return json_encode($res);
	}

	public function actionAddReport()
	{
		$data=Yii::$app->request->rawBody;
		$res=User::addReport($data);
		return json_encode($res);
	}


	public function actionModifyHouse()
	{
		$data=Yii::$app->request->rawBody;
		$res=User::ModifyHouse($data);
		return json_encode($res);
	}


	public function actionGetSearchHotKey()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=HotKey::GetSearchHotKey($obj);
		return json_encode($res);
	}

	public function actionAddWxPic()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=WeiXinPic::AddWxPic($obj);
		return json_encode($res);
	}

	public function actionGetSystemRecommend()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Supplyment::GetSystemRecommend($obj);
		return json_encode($res);
	}

	public function actionGetUserLimit()
	{
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);

		$res1=User::GetUserLimit($obj);
		if($res1['rscode']==1){
			return json_encode($res1); 
		}
		$res2=Supplyment::GetUserLimit($obj);
		if($res2['rscode']==1){
			return json_encode($res2); 
		}
		$res3=Requirement::GetUserLimit($obj);
		if($res3['rscode']==1){
			return json_encode($res3); 
		}
		$res=$res1;
		$res['user_supply_count']=$res2['user_supply_count'];
		$res['user_require_count']=$res3['user_require_count'];
		return json_encode($res);
	}

	public function actionUpdateLastlogintime($userid){
		$connection = Yii::$app->db;
		$sql = sprintf("UPDATE t_user set logintime= '%s',totaltimes = totaltimes+1 where  id = %s;",date('Y-m-d H:i:s',time()),$userid);
		$command = $connection->createCommand($sql);
		$command->execute();
	}

	/*
		经纪人体系 新增接口
	*/

	public function actionModifyAgent(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::modifyAgent($obj);
		if(0 == $res['rscode'])
		{
			$options['userid'] = $obj->userid;
			$options['type'] = 71;
			$options['dstid'] = $obj->userid;
			$options['dstuserid'] = 0;
			$options['city'] = empty($obj->city)?'上海市':$obj->city;
			UserOperate::addUserLog($options);
		}

		return json_encode($res);
	}

	public function actionGetAgentDetail(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getAgentDetail($obj);
		if(!empty($obj->loginuserid) && $obj->loginuserid != $obj->id)
		{
			$options['userid'] = $obj->loginuserid;
			$options['type'] = 73;
			$options['dstid'] = $obj->id;
			$options['dstuserid'] = $obj->id;
			$options['city'] = empty($obj->city)?'上海市':$obj->city;
			UserOperate::addUserLog($options);
		}
		return json_encode($res);
	}
	public function actionGetAgentExtra(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getAgentExtra($obj);
		return json_encode($res);
	}
	public function actionGetComment(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=AgentComment::getComment($obj);
		return json_encode($res);
	}
	public function actionAddComment(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=AgentComment::addComment($obj);
		return json_encode($res);
	}
	public function actionDeleteComment(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=AgentComment::deleteComment($obj);
		return json_encode($res);
	}
	public function actionGetColleague(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getColleague($obj);
		return json_encode($res);
	}
	public function actionGetNearColleague(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getNearColleague($obj);
		return json_encode($res);
	}
	public function actionGetCompetitor(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getCompetitor($obj);
		return json_encode($res);
	}
	
	public function actionGetAgentBehaviour(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=UserOperate::getAgentBehaviour($obj);
		return json_encode($res);
	}
	public function actionAddUserLog(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=UserOperate::addUserLog($obj);
		return json_encode($res);
	}
	public function actionGetBusinesscardStatistics(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=UserOperate::getBusinesscardStatistics($obj);
		return json_encode($res);
	}
	public function actionGetMyhouseStatistics(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=UserOperate::getMyhouseStatistics($obj);
		return json_encode($res);
	}
	public function actionGetMyestateStatistics(){
		$data=Yii::$app->request->rawBody;
		$obj = json_decode($data);
		$res=Agent::getMyestateStatistics($obj);
		return json_encode($res);
	}

    public function actionUpdateAllAgentDataCompleterate(){
        
        $res=Agent::UpdateAllAgentDataCompleterate();
        return json_encode($res);
    }
    public function actionGetTjjr(){
        $res=Agent::getTjjr();
        return json_encode($res);
    }
    function actionHeadpicUpload(){
		$base64 = $_POST['base64'];	
		$s = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64));
		$rand = rand(1000, 9999);
		$res['picname'] = date("YmdHis",time()) . $rand .'.jpg';
		$res['status'] = file_put_contents("../web/weixin/img/headpic/".$res['picname'], $s);

		return json_encode($res);
	}

	function actionImpicUpload(){
		$base64 = $_POST['base64'];	
		$s = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64));
		$rand = rand(1000, 9999);
		$res['picname'] = date("YmdHis",time()) . $rand .'.jpg';
		$res['status'] = file_put_contents("../web/weixin/img/Im/".$res['picname'], $s);

		return json_encode($res);
	}

	function actionLast(){
		$res=(new \yii\db\Query())->from('v_agent')->where('agentflag=1 and datacompleterate>0')->orderBy(['agent_id'=>SORT_DESC])->limit(10)->all();
        return json_encode($res);
	}
	function actionNo(){
		$num = file_get_contents('counter.txt');
		$num ++;
		file_put_contents('counter.txt', $num);
		return $num;
	}
}

?>

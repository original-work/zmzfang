<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Wechat;
use yii\helpers\Json;

class DoorController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionIndex()
	{
		$model = new Wechat();
		$model -> reponseMsg('欢迎关注芝麻找房，这是一个房产垂直领域共享平台

<a href="http://www.zmzfang.com/weixin/Mine/reg.html">【用户注册】</a>开启你的体验之旅

<a href="http://www.zmzfang.com/weixin/HomePage/searchAgent.html">【买房找人】</a>靠谱经纪人都在这里

<a href="http://www.zmzfang.com/weixin/Recruit/index.html">【求职招聘】</a>房产高薪职位等着你

如您有任何问题，请后台留言。');
	}

	public function actionScope($view){
		$p = Yii::$app->request->get();
		unset($p['r']);
		unset($p['view']);
		$p = serialize($p);
		$model = new Wechat();
		$url = $model -> getScope("http://www.zmzfang.com/?r=door/redirect","userinfo",$view,$p);
		header('Location:'.$url);
	}

	public function actionRedirect(){
		// header("Content-type:text/json;charset=utf-8");
		$request = Yii::$app->request->get();
		$code = $request['code'];
		$state = $request['state'];
		unset($request['r']);
		unset($request['code']);
		unset($request['state']);
		$p='';
		$i=0;
		foreach ($request as $key => $value) {
			if($i==0){
				$p.='?'.$key.'='.$value;
			}else{
				$p.='&'.$key.'='.$value;
			}
			$i++;
		}
		$model = new Wechat();
		$infoArray = $model->getInfo($code);
		// var_dump($infoArray);
		// exit;
		$openid = isset($infoArray->wxopenid)?$infoArray->wxopenid : $infoArray['openid'];
		$phone = isset($infoArray->phone)?$infoArray->phone : $infoArray['phone'];
		if(!$infoArray){
			header('Location:http://www.zmzfang.com/weixin/'.$state.'.html'.$p);
		}
		$refer = $state;
		if(!$phone){
			if(!isset($request['noPhoneNoJump'])){
				$state = "Mine/reg";
			}
		}
		
		$infoJson = Json::encode($infoArray);
		$infoJson = str_replace("wxopenid", "openid", $infoJson);
		// var_dump($infoJson);
		$strs = "localStorage.setItem('zmzfangLoginUserInfo','".$infoJson."');";
		$strs.= "localStorage.setItem('openid','".$openid."');";
		$strs.= "localStorage.setItem('refer','".$refer."');";
		
		header("Content-type:text/html;charset=utf-8");

		echo "<script type='text/javascript' charset='utf-8'>";

		// echo "&lt;script type='text/javascript' charset='utf-8'&gt;";

		echo "if(window.localStorage){
				 //alert('This browser supports localStorage');
				}else{
				 alert('This browser does NOT support localStorage');
			 }";
		echo $strs;
		echo "window.location.href='http://www.zmzfang.com/weixin/".$state.".html".$p."';";
		// echo "&lt;/script&gt;";
		echo "</script>";

	}

	public function actionGetJssdk($url){
		$model = new Wechat();
		$res = $model -> getSignPackage($url);
		return Json::encode($res);
	}
	public function actionFakeLogin(){

		$userid = intval(Yii::$app->request->post('userid'));
		
		if($userid && ($zminfo = \frontend\models\User::find()->select(['t_user.id','t_user.wxopenid AS openid','t_user.nickname','t_user.phone','t_user.picture','t_user.password','t_user.email','t_user.sex','t_user.city','t_user.realname','t_user.agentflag','t_user.identitycard','t_user.expertflag','t_user.srcflag','t_user.logintime','t_user.createtime','t_user.wxunionid','t_user.tags','t_user.validflag','t_expert.id as expertid'])->leftjoin('t_expert','t_user.id = t_expert.userid')->where(['t_user.id'=>$userid])->asArray()->one())){
                $connection = Yii::$app->db;
                $sql = sprintf("UPDATE t_user set logintime= '%s' where  id = %s;",date('Y-m-d H:i:s',time()),$zminfo['id']);
                $command = $connection->createCommand($sql);
                $command->execute();
        }
        $infoJson = Json::encode($zminfo);

		// var_dump($infoJson);

		$strs = "localStorage.setItem('zmzfangLoginUserInfo','".$infoJson."');";
		$strs.= "localStorage.setItem('openid','".$openid."');";

		header("Content-type:text/html;charset=utf-8");

		echo "<script type='text/javascript' charset='utf-8'>";

		// echo "&lt;script type='text/javascript' charset='utf-8'&gt;";

		echo "if(window.localStorage){
				 //alert('This browser supports localStorage');
				}else{
				 alert('This browser does NOT support localStorage');
			 }";
		echo $strs;
		echo "window.location.href='http://www.zmzfang.com/weixin/HomePage/index.html';";
		// echo "&lt;/script&gt;";
		echo "</script>";
	}
}
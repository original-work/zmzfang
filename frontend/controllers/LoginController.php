<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Login;
use yii\helpers\Json;
use frontend\models\User;
use common\models\Utils;

class LoginController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }


    // public function actionLogin()
    // {
    //     $model = new Login();
    //     $res = $model -> signup();
    //     switch ($res) {
    //     	case '0':
    //     		$json = ["rescode" => 0];
    //     		break;
    //     	case '1':
    //     		$json = ["rescode" => 1,"errdata"=>"手机号码已存在！"];
    //     		break;
    //     	// case '0':
    //     	// 	$json = ["rescode" => 1,"errdata"=>"手机号码已存在！"];
    //     	// 	break;
    //     	default:
    //     		$json = ["rescode" => 1,"errdata"=>"内部错误"];
    //     		break;
    //     }
    //     echo Json::encode($res);


    // }
    
    public function actionRegister()
    {
    		$data=Yii::$app->request->rawBody;
    		$obj = json_decode($data);
    		$retstr=User::register($obj);
    		return json_encode($retstr);
    }
    
    public function actionGetVerificationCode()
    {
        $data=Yii::$app->request->rawBody;
    		$obj = json_decode($data);
    		$retstr = Utils::GetVerificationCode($obj->phone);
				return json_encode($retstr);
    }
    
    public function actionVerifyVerificationCode()
    {
            $data=Yii::$app->request->rawBody;
    		$obj = json_decode($data);
    		$retstr = Utils::VerifyVerificationCode($obj->vcodeseq,$obj->vcode,$obj->phonenumber);
			return json_encode($retstr);
    }
    
    public function actionLogin()
    {
    		$data=Yii::$app->request->rawBody;
    		$obj = json_decode($data);
            $user=User::findUserByPhone($obj->phone);
            if(empty($user)){
        		$retstr['rscode']=1;
				$retstr['error']='用户不存在';
				return json_encode($retstr);
            }
            $retstr=$user->login($obj);
            return json_encode($retstr);
    }



    public function actionRegisterWeixin()
    {
            $data=Yii::$app->request->rawBody;
            $obj = json_decode($data);
            $retstr=User::registerWeixin($obj);
            return json_encode($retstr);
    }

    public function actionQrcode(){
        $m = new \common\models\Wechat();
        $token = $m::getWxAccessToken();
        $sid = time().$m->createNonceStr(8);
        return $this->render('qrcode',['sid'=>$sid,'qrcode'=>'<img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.\common\helpers\Curl::http_curl('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$token,1,["expire_seconds"=> 604800, "action_name"=> "QR_STR_SCENE", "action_info"=> ["scene"=> ["scene_str"=> $sid]]])['ticket'].'" />']);
    }

    public function actionSet($sid){
        $session = Yii::$app->session;
        $m =\frontend\models\PcLogin::find()->where(['sid'=>$sid])->one();
        if($m){
            $wechat = new \common\models\Wechat();
            $token = $wechat::getWxAccessToken();
            if($userInfo = $wechat->setUser($m->openid,$token,true)){
                $session['userInfo'] = $userInfo;
                return json_encode(['rscode'=>1]);

            }else{
                return json_encode(['rscode'=>2]);
            }
            
        }else{
            return json_encode(['rscode'=>0]);
        }
    }

    public function actionActivitySubmit(){
        $session = Yii::$app->session;
        if($session['userInfo']){
            $rows = (new \yii\db\Query())
            ->select(['organizationid', 'organization','organizationpic','organizationdetail','organizationlocation','contactname','contactphone'])
            ->from('t_activity_organization')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
            $plus= (new \yii\db\Query())
            ->select(['position', 'organization'])
            ->from('t_agent')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
            return $this->render('activitySubmit',['userInfo'=>$session['userInfo'],'org'=>$rows,'plus'=>$plus]);
        }else{
            return $this->redirect(['login/index']);
        }
    }
    public function actionActivityModify(){
        $aid = $_GET['id'];
        $session = Yii::$app->session;
        $userInfo = $session['userInfo'];
        if(!($userInfo && $aid)){
        	return $this->redirect(['login/index']);
        }
        
        // $userInfo = \frontend\models\User::find()->where(['id'=>10145])->asArray()->one();

        if(!$info = \frontend\models\Activity::find()->where(['activityid'=>$aid,'publishuserid'=> $userInfo['id']])->asArray()->one()){
        	return $this->redirect(['login/index']);
        }

        $rows = (new \yii\db\Query())
            ->select(['organizationid', 'organization','organizationpic','organizationdetail','organizationlocation','contactname','contactphone'])
            ->from('t_activity_organization')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
        $plus= (new \yii\db\Query())
            ->select(['position', 'organization'])
            ->from('t_agent')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
        return $this->render('activityModify',['info'=>$info,'userInfo'=>$userInfo,'org'=>$rows,'plus'=>$plus]);
    }
    public function actionTest($openid){
        if($userInfo = (new \yii\db\Query())
            ->from('t_user')
            ->where(['wxopenid' => $openid])
            ->one()){
            $rows = (new \yii\db\Query())
            ->select(['organizationid', 'organization','organizationpic','organizationdetail','organizationlocation','contactname','contactphone'])
            ->from('t_activity_organization')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
            $plus= (new \yii\db\Query())
            ->select(['position', 'organization'])
            ->from('t_agent')
            ->where(['validflag' => '1','userid'=>$userInfo['id']])
            ->one();
            // var_dump($rows);
            return $this->render('activitySubmit',['userInfo'=>$userInfo,'org'=>$rows,'plus'=>$plus]);
        }else{
            return $this->redirect(['login/index']);
        }
        
    }
    public function actionBack2wechat(){
        if(!$_GET['id']){
            return $this->redirect(['login/index']);
        }
        return $this->render('success');
    }
    public function actionUcenter(){
        $session = Yii::$app->session;
        $userInfo = $session['userInfo'];
        if(!($userInfo)){
            return $this->redirect(['login/qrcode']);
        }
        return $this->render('ucenter',['userInfo'=>$userInfo]);
    }
    public function actionActivityManage(){
        $session = Yii::$app->session;
        $userInfo = $session['userInfo'];
        if(!($userInfo)){
            return $this->redirect(['login/qrcode']);
        }
        $list = \frontend\models\Activity::find()->where(['publishuserid'=>$userInfo['id']])->asArray()->all();
        return $this->render('activityManage',['list'=>$list,'userInfo'=>$userInfo]);
    }
}

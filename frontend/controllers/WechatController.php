<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Functions;
use yii\helpers\Json;
use common\models\Wechat;
use frontend\models\User;


class WechatController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionSendTemplateMessage()
    {
    	$data=Yii::$app->request->rawBody;
    	$obj = Json::decode($data);
    	if(empty($obj['toUserid'])){
    		return [];
    	}
        $res = static::sendTemplateMessage($obj);
        return Json::encode($res);
    }

    public function actionSetMenu()
    {
    	// exit;
        $model = new Wechat();
        $data = ['button'=>[
            ['type'=>'view','name'=>'我要买房','url'=>'http://www.zmzfang.com/weixin/HomePage/index.html'],
            ['type'=>'view','name'=>'行业八卦','url'=>'http://www.zmzfang.com/weixin/Topic/shuoshuo.html'],

            // ['type'=>'view','name'=>'快问','url'=>'http://www.zmzfang.com/weixin/Expert/expert.html'],
            // ['type'=>'view','name'=>'个人中心','url'=>'http://www.zmzfang.com/weixin/mine.html'],
            ["name"=>"个人中心","sub_button"=>[
                ['type'=>'view','name'=>'用户绑定',"url"=>"http://www.zmzfang.com/?r=door/scope&view=Mine/reg"],
                ['type'=>'view','name'=>'个人中心',"url"=>"http://www.zmzfang.com/?r=door/scope&view=mine"],
                ['type'=>'view','name'=>'实用工具',"url"=>"http://www.zmzfang.com/weixin/Tools/index.html"],
                ['type'=>'media_id','name'=>'买房交流',"media_id"=>"oLde74HHxAIcvaC7Ds1frC3SHrl6tIuV3IxRBrtFKKw"],
            ]],
            // ['type'=>'view','name'=>'用户绑定',"url"=>"http://www.zmzfang.com/?r=door/scope&view=Mine/reg"],
            // ['type'=>'view','name'=>'转盘活动',"url"=>"https://hd.faisco.cn/10724942/7/load.html?style=0"],
            // ['type'=>'media_id','name'=>'买房交流',"media_id"=>"oLde74HHxAIcvaC7Ds1frC3SHrl6tIuV3IxRBrtFKKw"],
            // ["name"=>"实用工具","sub_button"=>[
            //     ['type'=>'view','name'=>'限购查询',"url"=>"http://www.zmzfang.com/weixin/Tools/canbuy.html"],
            //     ['type'=>'view','name'=>'税费计算',"url"=>"http://www.zmzfang.com/weixin/Tools/tax.html"],
            //     ['type'=>'view','name'=>'贷款计算',"url"=>"http://www.zmzfang.com/weixin/Tools/loan.html"],
            //     // ['type'=>'media_id','name'=>'买房交流',"media_id"=>"oLde74HHxAIcvaC7Ds1frC3SHrl6tIuV3IxRBrtFKKw"],
            //     // ['type'=>'view','name'=>'产调申请',"url"=>"http://www.zmzfang.com/weixin/Tools/cd.html"]
            // ]],
        ]];
        var_dump($model ->createMenu($data));
        var_dump($data);
        
    }

    static function sendTemplateMessage($obj)
    {
        $model = new Functions();
        $template = array();
        $template['data'] = array();
        $toUserInfo = User::isNeedSms($obj['toUserid']);
        if(empty($toUserInfo['openid']) && $obj['templateId']==1){
            $model->sendSms($toUserInfo['phone'],1); // 发送聊天时 判断用户是否存在openid，不存在发送sms
            return [];
        }
        switch ($obj['templateId']) {
                case 1:
                    $content = isset($obj['content'])?$obj['content']:"点击下方查看详情";
                    $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的消息请查收';
                    $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
                    $columns = ['first','keyword1','keyword2','keyword3'];
                    $str = [$first,$obj['fromNickname'],date('Y-m-d',time()),$content];
                    $col = [];
                    $url = 'http://www.zmzfang.com/?r=door/scope&view=Message/im-chat&id='.$obj['fromUserid'];
                    break;
                case 2:
                    $content = $obj['content'].",点击下方查看详情";
                    $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的信息';
                    $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
                    $columns = ['first','keyword1','keyword2','keyword3'];
                    $str = [$first,$obj['fromNickname'],date('Y-m-d',time()),$content];
                    $col = [];
                    $url = $obj['url'];
                    $model->sendSms($toUserInfo['phone']); 
                    // 可加更多判断  投标状态
                    // 有房源给你投标，给需求方短信。房源中标，给房源方发短信
                    break;
                default:
                    
                    break;
        }
        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['openid'];
        $template['url']    = $url;
        
        if(!empty($toUserInfo['openid'])){
            $Wechatmodel = new Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
            if($res['errcode'] != 0 && $obj['templateId']==1){
                $model->sendSms($toUserInfo['phone'],1);
                //发送聊天时， 发送模板消息失败（未订阅或者其他错误） 发送短信
            }
        }else{
            $res =[];
        }
        
        return $res;
    }
    //ForeverMaterial
    public function actionUploadFM(){
    	exit;
    	$model = new Wechat();
   //  	"articles": [{
		 //       "title": TITLE,
		 //       "thumb_media_id": THUMB_MEDIA_ID,
		 //       "author": AUTHOR,
		 //       "digest": DIGEST,
		 //       "show_cover_pic": SHOW_COVER_PIC(0 / 1),
		 //       "content": CONTENT,
		 //       "content_source_url": CONTENT_SOURCE_URL
		 //    },
		 //    //若新增的是多图文素材，则此处应有几段articles结构，最多8段
		 // ]
    	$data = ['articles'=>[['title'=>'买房交流群','thumb_media_id'=>'oLde74HHxAIcvaC7Ds1frDEjqfXbvAwDasJaICvkv_M','author'=>'芝麻找房','digest'=>'加入芝麻找房买房交流群,<br />看房、贷款、产证、过户问题大家帮','show_cover_pic'=>1,'content'=>'<p style="text-align:center">加入芝麻找房买房交流群,</p><p style="text-align:center">看房、贷款、产证、过户问题大家帮</p><p style="text-align:center;"<img src="http:\/\/mmbiz.qpic.cn\/mmbiz\/jh05MOYmZ9bLD7JtlQ2l8cORlUwGtoCs2IQsZLZPS0hzkvCFWuL3lEMqB3XaQpjMB315RvhicpicOfjqk4UH6a0w\/0" /></p>','content_source_url'=>'']]];
    	var_dump($model ->uploadFM($data));
    }

    public function actionGetFMList(){
    	exit;
    	$model = new Wechat();
    	$data = ['type'=>'news','offset'=>0,'count'=>2];
    	var_dump($model ->getFMList($data));
    }
    // public actionUploadImg(){
    // 	$path = '/path/to/zmzfang/640.webp';

    // }

    public function actionWepay(){
        // https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1

        $model = new Wechat();
        $body = '产调付费';
        $openid = $_POST['openid'];
        $attach = '仟房网';
        $price = 4500;
        $backup = 'http://www.zmzfang.com/webackurl.html';
        $tags = 'qianfangwangchandiao';
        $type = 'JSAPI';
        /*
            如事先未创建orderid 请留空参数
            $out_trade_no = null;
        */
        $out_trade_no = $_POST['orderid'];
        $response = $model->wepay_setorder($openid,$body,$attach,$price,$backup,$tags,$type,$out_trade_no);
        // var_dump([$openid,$body,$attach,$price,$backup,$tags,$type,$out_trade_no]);
        // var_dump($response);
        Yii::error("actionWepay openid:".$openid);
        Yii::error("actionWepay:" . json_encode($response));
        $return_msg = $response["return_msg"];
        Yii::error("actionWepay return_msg1 :" . $return_msg);
        
        if($response->return_code == 'SUCCESS' && $response->result_code == 'SUCCESS'){
            /*
                创建微信jsapi参数
            */
            $res['appId'] = $model::$appid;
            $res['package'] = "prepay_id=".$response->prepay_id;
            $res['timeStamp'] = time();
            $res['nonceStr'] = $model->createNonceStr(32);
            $res['signType'] = 'MD5';
            $paySign = $model->createSign($res);
            $res['paySign'] = $paySign;
            return  json_encode($res);
        }else{
            return  json_encode(['code'=>0]);
        }
    }
    
     public function actionPayPublicAccount($WIDout_trade_no,$WIDsubject,$WIDtotal_fee,$WIDbody,$code,$WIDopenid)
     {
        // https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1

        $model = new Wechat();
        $body = $WIDbody;
        $openid = $WIDopenid;
        $attach = '专家';
        $price = $WIDtotal_fee *100;
        $backup = 'http://www.zmzfang.com/notify.html';
        $tags = 'shouting';
        $type = 'JSAPI';
        /*
            如事先未创建orderid 请留空参数
            $out_trade_no = null;
        */
        $out_trade_no = $WIDout_trade_no;
        $response = $model->wepay_setorder($openid,$body,$attach,$price,$backup,$tags,$type,$out_trade_no);
        // var_dump([$openid,$body,$attach,$price,$backup,$tags,$type,$out_trade_no]);
        // var_dump($response);
        Yii::error("actionWepay openid:".$openid);
        Yii::error("actionWepay:" . json_encode($response));
        $return_msg = $response["return_msg"];
        Yii::error("actionWepay return_msg1 :" . $return_msg);
        
        if($response->return_code == 'SUCCESS' && $response->result_code == 'SUCCESS'){
            /*
                创建微信jsapi参数
            */
            $res['appId'] = $model::$appid;
            $res['package'] = "prepay_id=".$response->prepay_id;
            $res['timeStamp'] = time();
            $res['nonceStr'] = $model->createNonceStr(32);
            $res['signType'] = 'MD5';
            $paySign = $model->createSign($res);
            $res['paySign'] = $paySign;
            return  json_encode($res);
        }else{
            return  json_encode(['code'=>0]);
        }
    }
    
    function actionSetorder(){
        $r = $_POST;
        $model = new \frontend\models\Cd();
        $model->mobile = $r['mobile'];
        $model->area = $r['area'];
        $model->address = $r['address'];
        $model->openid = $r['openid'];
        $model->orderid = Wechat::$mchid.date("YmdHis");
        $model->time = time();
        $model->status = 0;
        if($model->save()){
            return json_encode(['code'=>1,'orderid'=>$model->orderid]);
        }
            return json_encode(['code'=>0]);
    }
    /*
        待修复：微信回调无响应 多次回调 应 依据orderid 来判断是否已回调 已避免多次推到仟房！
    */ 
    function actionBackurl(){
        header("Content-type:text/xml");
        $postStr = file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $postObj = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        
        Yii::error("postobj is ".print_r($postObj,1)."\n");

        if(!$postObj){
            exit('<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[no data]]></return_msg>
                </xml>');
        }
        ksort($postObj);
        $buff= '';
        foreach ($postObj as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=507e7d15ef798934454cf7b0513e979d";
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($string);

        if($postObj['sign']!=$sign){
            exit('<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[sign wrong!]]></return_msg>
                </xml>');
        }
        $model = new \frontend\models\Order();
        $model->out_trade_no = $postObj['out_trade_no'];
        $model->attach = $postObj['attach'];
        $model->time_end = $postObj['time_end'];
        $model->fee_type = $postObj['fee_type'];
        $model->total_fee = $postObj['total_fee'];
        $model->bank_type = $postObj['bank_type'];
        $model->trade_type = $postObj['trade_type'];
        $model->openid = $postObj['openid'];
        $model->result_code = $postObj['result_code'];
        $model->err_code = $postObj['err_code'];
        $model->err_code_des = $postObj['err_code_des'];
        $model->coupon_count = $postObj['coupon_count'];
        $model->coupon_fee = $postObj['coupon_fee'];
        $model->sign = $postObj['sign'];
        if($res = $model->save()){
            $cdData = \frontend\models\Cd::find()->where(['orderid'=>$postObj['out_trade_no']])->asArray()->one();
            $connection = Yii::$app->db;
            $area = $cdData['area'];
            $address = $cdData['address'];
            $mobile = $cdData['mobile'];
            $appid = '4d71b19e67';
            $method = 'submit';
            $token = '68ab09aee3fb14eb959f635a904744ef';
            $strs = "address=".$address."&appid=".$appid."&area=".$area."&mobile=".$mobile."&timestamp=".time();
            $sign = strtolower(md5($strs.$token));
            ///*
            $cdRes= \common\helpers\Curl::http_curl("http://www.1001fang.com/cdapi/".$method."/?".$strs."&sign=".$sign);
            if($cdRes['code'] == 1){
                $cdId = $cdRes['response']['id'];
                $reason = '';
                $status = 1;
            }else{
                $cdId = '';
                $reason = $cdRes['error'];
                $status = -1;
            }
            $sql = sprintf("UPDATE t_cd set cdid = '%s' ,status= '%s',reason = '%s' where  id = '%s';",$cdId,$status,$reason,$cdData['id']);
            //*/
            // $sql = sprintf("UPDATE t_cd set cdid = %s ,status= '%s',reason = '%s' where  id = %s;",111,1,'',19);
            $command = $connection->createCommand($sql);
            if($command->execute()){

            }else{
                Functions::caution('修改产调订单出错，订单号：'.$postObj['out_trade_no']);
            }
            yii::error("cdres is ".print_r($cdRes,1));
            Yii::error("sql is ".$sql."\n");

        }else{
            Functions::caution('保存产调回调信息出错，订单号：'.$postObj['out_trade_no']);
        }


        // Yii::error("sql is ".print_r((boolean)$res,1)."\n");

        echo    '<xml>
                  <return_code><![CDATA[SUCCESS]]></return_code>
                  <return_msg><![CDATA[OK]]></return_msg>
                </xml>';
    }
    
    function actionNotify(){
        header("Content-type:text/xml");
        $postStr = file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $postObj = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        
        Yii::error("postobj is ".print_r($postObj,1)."\n");

        if(!$postObj){
            exit('<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[no data]]></return_msg>
                </xml>');
        }
        ksort($postObj);
        $buff= '';
        foreach ($postObj as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=507e7d15ef798934454cf7b0513e979d";
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($string);
 				Yii::error("sign is ".$sign."\n");
 				Yii::error("postobj sign is ".$postObj['sign']."\n");
        if($postObj['sign']!=$sign){
            exit('<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[sign wrong!]]></return_msg>
                </xml>');
        }
        $model = new \frontend\models\Order();
        $model->out_trade_no = $postObj['out_trade_no'];
        $model->attach = $postObj['attach'];
        $model->time_end = $postObj['time_end'];
        $model->fee_type = $postObj['fee_type'];
        $model->total_fee = $postObj['total_fee'];
        $model->bank_type = $postObj['bank_type'];
        $model->trade_type = $postObj['trade_type'];
        $model->openid = $postObj['openid'];
        $model->result_code = $postObj['result_code'];
        $model->err_code = $postObj['err_code'];
        $model->err_code_des = $postObj['err_code_des'];
        $model->coupon_count = $postObj['coupon_count'];
        $model->coupon_fee = $postObj['coupon_fee'];
        $model->sign = $postObj['sign'];
        $time = date('Y-m-d H:i:s',time());
        $time2 = date('Ymd',time());
        $connection = Yii::$app->db;
        if($res = $model->save()){
            $template = array();
            $template['data'] = array();
            if(substr($model->out_trade_no,0,2) == 'ST'){
                // ST 收听 无需模板消息  需要分成 更新状态
                $orderToUserid = \frontend\models\PayQuestion::find()->where(['orderid'=>$model->out_trade_no])->one();
                $orderToUserid->status = 1;
                $orderToUserid->save();

                //专家account
                $account = \frontend\models\Account::find()->where(['userid'=>$orderToUserid->questionexpertid])->one();
                $account->historyincome += 0.5;
                $account->historyprofit += 0.45;
                $account->remainedprofit += 0.45;
                $account->updatetime = $time;
                $account->save();

                //用户account
                $Uaccount = \frontend\models\Account::find()->where(['userid'=>$orderToUserid->questionuserid])->one();
                if($Uaccount){
                    $Uaccount->historyincome += 0.5;
                    $Uaccount->historyprofit += 0.45;
                    $Uaccount->remainedprofit += 0.45;
                    $Uaccount->updatetime = $time;
                    $Uaccount->save();
                }else{
                    $toUserInfo=User::find()->select('wxopenid,phone,wxunionid,id,nickname')->where(['id'=>$orderToUserid->questionuserid])->asArray()->one();
                    $newAccount = new \frontend\models\Account();
                    $newAccount->userid = $orderToUserid->questionuserid;
                    $newAccount->usertype = 1;
                    $newAccount->openid = $toUserInfo['wxopenid'];
                    $newAccount->historyincome = 0.5;
                    $newAccount->historyprofit = 0.45;
                    $newAccount->drawedprofit =0;
                    $newAccount->usedprofit = 0;
                    $newAccount->remainedprofit = 0.45;
                    $newAccount->lockingprofit =0;
                    $newAccount->createtime = $time;
                    $newAccount->updatetime = $time;
                    $newAccount->save();
                }
                
                

                //新增账户 detail 表
                $sql = sprintf("INSERT INTO t_account_detail (userid,usertype,sumdate,accounttype,servicetype,originalfee,actualfee,subject,ordertype,orderid,createtime)VALUES ($orderToUserid->questionuserid, 1, '$time2', '10','1003','0.5','0.45','收听分成','3','$model->out_trade_no','$time'),($orderToUserid->questionexpertid, 2, '$time2', '10','1003','0.5','0.45','收听分成','3','$model->out_trade_no','$time')");
                Yii::error("sql is ".$sql."\n");
                $command = $connection->createCommand($sql);
                $command->execute();
            }elseif(substr($model->out_trade_no,0,2) == 'qz'){
                $forHelp = \frontend\models\ForHelp::findOne(substr($model->out_trade_no,2));
                $forHelp -> status = 1;
                $forHelp -> publishuserpaytime = date('Y-m-d H:i:s' , time());
                $forHelp ->save();   
            }else{
                $orderToUserid = \frontend\models\Appointment::findOne(['id'=>$model->out_trade_no]);
                if($orderToUserid->appointmenttype == 1){
                    $orderToUserid -> status =1;
                }else{
                    $orderToUserid -> status =2;
                }
								$orderToUserid ->save();
								
                $ExpertInfo=\frontend\models\Expert::find()->select('name,userid')->where(['id'=>$orderToUserid->expertid])->asArray()->one();
                $toUserInfo=User::find()->select('wxopenid,phone,wxunionid,id,nickname')->where(['in','id',[$orderToUserid->userid,$ExpertInfo['userid']]])->asArray()->all();
                if($toUserInfo[0]['id'] == $orderToUserid->userid){
                    $toUser = $toUserInfo[1];
                    $fromUser = $toUserInfo[0];
                }else{
                    $toUser = $toUserInfo[0];
                    $fromUser = $toUserInfo[1];
                }
                
                //处理状态
                $appointStatus = new \frontend\models\ExpertAppointmentStatus();
                $appointStatus->orderid = $model->out_trade_no;
                $appointStatus->orderstatus = $orderToUserid->appointmenttype;
                $appointStatus->statustime = $time;
                $appointStatus->operator = $fromUser['nickname'];
                $appointStatus->save();

								//  start 模板消息                
                $fromNickname='系统通知';
                $url='http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/AppointmentMeList';
                
                $content = "点击下方查看详情";
                $first = '您好,'.$ExpertInfo['name'].'专家，您的客户'.$fromUser['nickname'].'已付款。请尽快跟进！';
                $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
                $columns = ['first','keyword1','keyword2','keyword3'];
                $str = [$first,$fromNickname,date('Y-m-d H:i:s',time()),$content];
                $col = [];

                foreach($columns as $key => $value){
                    $template['data'][$value]['value'] = $str[$key];
                    if(count($col)){
                        $template['data'][$value]['color'] = $col[$key];
                    }
                }
                $template['touser'] = $toUser['wxopenid'];
                $template['url']    = $url;
                
                if(!empty($toUser['wxopenid'])){
                    $Wechatmodel = new Wechat();
                    $res = $Wechatmodel -> sendTemplateMessage($template);
                }else{
                    $res =[];
                }
                // end 模板消息

            }

            
        }else{
            Functions::caution('保存订单信息出错，订单号：'.$postObj['out_trade_no']);
        }
        Yii::error("out_trade_no is ".$postObj['out_trade_no']."\n");

        echo    '<xml>
                  <return_code><![CDATA[SUCCESS]]></return_code>
                  <return_msg><![CDATA[OK]]></return_msg>
                </xml>';
    }


    //判断是否关注
    function actionIsSubscribe($openid){
        $model = new wechat();
        $res = $model->getSubscribeInfo($openid);
        return json_encode($res); 
    }

}
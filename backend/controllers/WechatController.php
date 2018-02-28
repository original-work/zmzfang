<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use common\models\Wechat;


class WechatController extends Controller
{
    public function beforeAction($action){  
        if(Yii::$app->user->isGuest){  
            return $this->goHome();
        }else{
            return parent::beforeAction($action);  
        }
    }
    function actionSendquan(){
    	if (!Yii::$app->request->post()) {
    		return $this->render('sendquan');
    		exit;
    	}
    	header("Content-type:text/xml");

        $model = new Wechat();
        $parameter['appid'] = $model::$appid;
        $parameter['mch_id'] = $model::$mchid;
        $parameter['coupon_stock_id'] = Yii::$app->request->post('id');

        $parameter['nonce_str'] = $model->createNonceStr(32);
        $parameter['openid'] = Yii::$app->request->post('openid');
        $parameter['openid_count'] = 1;
        $parameter['partner_trade_no'] = $model::$mchid.date("YmdHis");
        ksort($parameter);
        // var_dump($parameter);
        $buff= '';
        foreach ($parameter as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        // var_dump($buff);

        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=".$model::$key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($string);
        
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/send_coupon';
        $template = '<xml>
<appid><![CDATA[%s]]></appid>
<coupon_stock_id><![CDATA[%s]]></coupon_stock_id>
<mch_id><![CDATA[%s]]></mch_id>
<nonce_str><![CDATA[%s]]></nonce_str>
<openid><![CDATA[%s]]></openid>
<openid_count>1</openid_count>
<partner_trade_no><![CDATA[%s]]></partner_trade_no>
<sign><![CDATA[%s]]></sign>
</xml>';
        $xml = sprintf($template, $parameter['appid'], $parameter['coupon_stock_id'], $parameter['mch_id'], $parameter['nonce_str'], $parameter['openid'], $parameter['partner_trade_no'],$sign);
        $res = \common\helpers\Curl::http_curl_ssl($url,$xml);
        return $res;
    }
    function actionTixian(){
        if(!Yii::$app->request->get('id')){
            exit('error');
        }
        $data = \backend\models\Cash::findOne(Yii::$app->request->get('id'));
        if($data->usertype == 2){
            $user = \backend\models\User::find()->select('t_user.wxopenid')->where(['t_expert.id'=>$data->userid])->leftjoin('t_expert','t_expert.userid = t_user.id')->asArray()->one();
        }else{
            $user = \backend\models\User::find()->select('wxopenid')->where(['id'=>$data->userid])->asArray()->one();
        }
        
        if(!$user['wxopenid']){
            exit('该用户不存在openid，无法提现！');
        }

        if($data->status !=4  && $data->validflag ==1){
        $data -> validflag = 0;
        if($data -> save()){}else{exit('出错，请重试！');}
        $model = new Wechat();
        $parameter['mch_appid'] = $model::$appid;
        $parameter['mchid'] = $model::$mchid;
        $parameter['nonce_str'] = $model->createNonceStr(32);
        $parameter['amount'] = $data->amount*100;
        $parameter['openid'] = $user['wxopenid'];
        $parameter['partner_trade_no'] = $model::$mchid.date("YmdHis");
        $parameter['check_name'] = 'NO_CHECK';
        $parameter['desc'] = '芝麻找房用户提现';
        $parameter['spbill_create_ip'] = Yii::$app->getRequest()->getUserIP();
        ksort($parameter);
        // var_dump($parameter);
        // var_dump($parameter);
        $buff= '';
        foreach ($parameter as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        // var_dump($buff);

        //签名步骤二：在string后加入KEY
        $string = $buff . "&key=".$model::$key;
        // var_dump($string);
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($string);
        // var_dump($sign);
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $template = '<xml> 
<mch_appid><![CDATA[%s]]></mch_appid> 
<mchid><![CDATA[%s]]></mchid> 
<nonce_str><![CDATA[%s]]></nonce_str> 
<partner_trade_no><![CDATA[%s]]></partner_trade_no> 
<openid><![CDATA[%s]]></openid> 
<check_name><![CDATA[%s]]></check_name> 
<amount><![CDATA[%s]]></amount> 
<desc><![CDATA[%s]]></desc> 
<spbill_create_ip><![CDATA[%s]]></spbill_create_ip> 
<sign><![CDATA[%s]]></sign> 
</xml>
';
        $xml = sprintf($template, $parameter['mch_appid'], $parameter['mchid'], $parameter['nonce_str'],$parameter['partner_trade_no'], $parameter['openid'], $parameter['check_name'],$parameter['amount'],$parameter['desc'],$parameter['spbill_create_ip'],$sign);
        $res = \common\helpers\Curl::http_curl_ssl($url,$xml);
        $obj = (array)simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        echo "<h1>调试信息,出现问题，请截图或者复制，连同此段发送给程序员</h1>";
        var_dump($obj);
        echo '<hr />';

        if($obj['result_code'] == 'SUCCESS'){
            $data -> updatetime = date('Y-m-d H:i:s');
            $data -> status = 4;
            if($data->save()){
                echo '提现成功';
            }else{
                echo '钱付出去拉，但是程序出毛病拉！请去微信后台确认下钱打没打 再联系程序员吧！！！';
            }
            
        }
        }else{
            exit('提现已锁定，如有问题，请联系程序员');
        }
        
    }
}
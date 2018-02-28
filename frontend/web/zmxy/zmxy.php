<?php
include('./ZmopClient.php');
include('./request/ZhimaCreditWatchlistiiGetRequest.php');
include('./request/ZhimaAuthInfoAuthorizeRequest.php');
class TestZhimaCreditWatchlistiiGet {
    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户私钥文件
    public $privateKeyFile = "./rsa_private_key.pem";
    //芝麻公钥文件
    public $zmPublicKeyFile = "./zm_public_key.pem";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "1001720";
    
    public function testiiGet(){
         $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
         $request = new ZhimaCreditWatchlistiiGetRequest();
         $request->setPlatform("zmop");
         $request->setProductCode("w1010100100000000022");// 必要参数  产品码
         $microtime= explode(" ", microtime());
         $time = substr((float)$microtime[0],2,3);

         $request->setTransactionId(date('YmdHis').$time."000000000001");// 必要参数  000000000001 => 订单id
         $request->setOpenId($_GET['openid']);// 必要参数  268810000007909449496 => 芝麻信用接入的userid
         $response = $client->execute($request);
         echo json_encode($response);
    }
    /*
    1).业务扩展字段,页面授权接口需要传入auth_code,channelType,state
    auth_code授权码,值取决于授权方式和身份类型：
    a). PC方式,身份类型identity_type=1: {"auth_code":"M_MOBILE_APPPC"}
    此方式下的channelType分配值为apppc；
    b). PC方式,身份类型identity_type=2: {"auth_code":"M_APPPC_CERT"}
    此方式下的channelType分配值为apppc；
    c). H5方式(身份类型identity_type为任何值): {"auth_code":"M_H5"}
    此方式下的channelType分配值为app；
    d).SDK方式(身份类型identity_type为任何值): {"auth_code":"M_APPSDK"}
    此方式下的channelType分配值为appsdk；
     
    2).channelType渠道类型,每个授权码支持不同的渠道类型
    appsdk:sdk接入
    apppc:商户pc页面接入
    api:后台api接入
    windows:支付宝服务窗接入
    app:商户app接入
     
    3).state是商户自定义的数据,页面授权接口会原样把这个数据返回个商户
    */
    public function testZhimaAuthInfoAuthorize(){
         $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
         $request = new ZhimaAuthInfoAuthorizeRequest();
         $request->setChannel("apppc");
         $request->setPlatform("zmop");
         //2 通过身份证  1 通过手机号
         if($_GET['type'] == 1){
            $request->setIdentityType("1");   
            $request->setIdentityParam("{\"mobileNo\":\"".$_GET['mobile']."\"}");
            $request->setBizParams("{\"auth_code\":\"M_MOBILE_APPPC\",\"channelType\":\"apppc\",\"state\":\"商户自定义\"}");
         }else{
            $request->setIdentityType("2");   
            $request->setIdentityParam("{\"name\":\"黄晓健\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\"310229199009150257\"}");
            $request->setBizParams("{\"auth_code\":\"M_APPPC_CERT\",\"channelType\":\"apppc\",\"state\":\"商户自定义\"}");
         }
         
         

         $url = $client->generatePageRedirectInvokeUrl($request);
         header('location:'.$url);
    }
    public function testZhimaAuthInfoAuthquery(){
         $client = new ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->privateKeyFile,$this->zmPublicKeyFile);
         $request = new ZhimaAuthInfoAuthqueryRequest();
         $request->setChannel("apppc");
         $request->setPlatform("zmop");
                 $request->setIdentityType("0");// 必要参数         
                $request->setIdentityParam("{\"openId\":\"268818717826095906908243981\"}");// 必要参数         
                  $response = $client->execute($request);
          echo json_encode($response);
    }

}

$model = new TestZhimaCreditWatchlistiiGet();
if(isset($_GET['mobile'])){
   $model->testZhimaAuthInfoAuthorize();
}else{
   $model->testiiGet(); 
}


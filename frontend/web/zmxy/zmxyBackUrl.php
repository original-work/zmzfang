<?php
	include('./ZmopClient.php');
	$params = $_GET['params'];
    //从回调URL中获取params参数，此处为示例值
    $sign = $_GET['sign'];
    //从回调URL中获取sign参数，此处为示例值
    // 判断串中是否有%，有则需要decode
    $params = strstr ( $params, '%' ) ? urldecode ( $params ) : $params;
    $sign = strstr ( $sign, '%' ) ? urldecode ( $sign ) : $sign;

    $client = new ZmopClient ( "https://zmopenapi.zmxy.com.cn/openapi.do", "1001720", "UTF-8", "./rsa_private_key.pem", "./zm_public_key.pem" );
    $result = $client->decryptAndVerifySign ( $params, $sign );
    $array = explode('&', $result);
    foreach ($array as $value) {
        $array2 = explode('=',$value);
        $strs[$array2[0]] = $array2[1];
    }
    var_dump($strs);
    if($strs['open_id']){
        header('location:http://www.zmzfang.com/zmxy/zmxy.php?openid='.$strs['open_id']);
    }
    //open_id=268818717826095906908243981&error_message=%E6%93%8D%E4%BD%9C%E6%88%90%E5%8A%9F&state=%E5%95%86%E6%88%B7%E8%87%AA%E5%AE%9A%E4%B9%89&error_code=SUCCESS&app_id=1001720&success=true
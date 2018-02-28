<?php

namespace backend\controllers;

use Yii;
use common\helpers\Curl;
use yii\web\Controller;
// use backend\models\Im;

class ImController extends Controller
{
    function actionGet(){
    	$curl = new Curl();
        $response = $curl->get('https://zmzf0001.wilddogio.com/test.json?print=pretty');
        var_dump($response);
    }
    function actionPost(){
    	//不建议使用，会自建子元素，下转 Put
    	$curl = new Curl();

		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "content": "您的投标被接受，所投需求的主题是求购明天华城2室需求发布人：sickeeer，请您查收。接受时间：2016/8/9 下午3:34:57",
				    "headUrl": "http://www.zmzfang.com/weixin/img/favicon.ico",
				    "num": 1,
				    "offlinenum": 0,
				    "sendee": "10040",
				    "sendeenickname": "sickeeer",
				    "sender": "system",
				    "sendernickname": "系统消息",
				    "time": "20161231112157",
				    "type": "template",
				    "template": {
				    	"imgsrc":"https://img.wdstatic.cn/console/images/logo-632b60596e.svg",
				    	"url":"http://www.baidu.com",
				    	"title":"XXX对您的房源XXX感兴趣",
				    	"describe":"点我进行查看"
				    }
				}'
            )
            ->post('https://zmzf0001.wilddogio.com/10040/system/'.date('Ymdhis').'.json');
        var_dump($response);
    }
    function actionPut(){
    	$curl = new Curl();

		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "content": "您的投标被接受，所投需求的主题是求购明天华城2室需求发布人：sickeeer，请您查收。接受时间：2016/8/9 下午3:34:57",
				    "headUrl": "http://www.zmzfang.com/weixin/img/favicon.ico",
				    "num": 1,
				    "offlinenum": 0,
				    "sendee": "10040",
				    "sendeenickname": "sickeeer",
				    "sender": "system",
				    "sendernickname": "系统消息",
				    "time": "20161231112157",
				    "type": "template",
				    "template": {
				    	"imgsrc":"https://img.wdstatic.cn/console/images/logo-632b60596e.svg",
				    	"url":"http://www.baidu.com",
				    	"title":"XXX对您的房源XXX感兴趣",
				    }
				}'
            )
            ->put('https://zmzf0001.wilddogio.com/10040/system/'.date('Ymdhis').'.json');
        var_dump($response);
    }
    function actionPatch($id){
    	$curl = new Curl();

		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "first": "Mary"}'
            )
            ->patch('https://zmzf0001.wilddogio.com/test/'.$id.'.json');
        var_dump($response);
    }
    function actionDelete(){
    	$curl = new Curl();

		$response = $curl->delete('https://zmzf0001.wilddogio.com/test.json');
        var_dump($response);
    }
}

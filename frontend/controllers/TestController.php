<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Account;
use common\helpers\Curl;

class TestController extends Controller
{
	public $enableCsrfValidation = false;
	
	function actionGet(){
		Yii::error("actionGet\n");
    	$curl = new Curl();
        $response = $curl->get('https://haiwei.wilddogio.com/test.json?print=pretty');
        var_dump($response);
    }

    function actionPost(){
    	Yii::error("actionPost\n");
    	$curl = new Curl();
		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "first": "Jack", "last": "Sparrow" }'
            )
            ->post('https://haiwei.wilddogio.com/test/'.date('Ymdhis').'.json');
        var_dump($response);
    }


    function actionPost1(){
    	Yii::error("actionPost1\n");
    	$curl = new Curl();
		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                http_build_query(array(
                    'myPostField' => 'value'
                )
            ))
            ->post('https://haiwei.wilddogio.com/test/'.date('Ymdhis').'.json');
        var_dump($response);
    }

    function actionPut(){
    	Yii::error("actionPut\n");
    	$curl = new Curl();
		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "first": "Jack", "last": "Sparrow" }'
            )
            ->put('https://haiwei.wilddogio.com/test/'.date('Ymdhis').'.json');
        var_dump($response);
    }

    function actionPatch($id){
    	Yii::error("actionPatch\n");
    	$curl = new Curl();
		$response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                '{ "first": "Mary"}'
            )
            ->patch('https://haiwei.wilddogio.com/test/'.$id.'.json');
        var_dump($response);
    }

    function actionDelete(){
    	Yii::error("actionDelete\n");
    	$curl = new Curl();
		$response = $curl->delete('https://haiwei.wilddogio.com/test.json');
        var_dump($response);
    }

}
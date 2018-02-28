<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Account;
use common\helpers\Curl;

class SucaiController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionRecieve()
	{
		$postStr = file_get_contents("php://input");
		if (!empty($postStr)){
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $ComponentVerifyTicket = $postObj->ComponentVerifyTicket;
                Yii::error(print_r($postObj));
                Yii::error($ComponentVerifyTicket);

	            // Yii::$app->cache->set('verifyTicket',$ComponentVerifyTicket , 7000);
	      	
        }else{
        	echo 'its done';
        }
	}
}
<?php

namespace backend\controllers;

use Yii;
use common\helpers\Functions;
use yii\web\Controller;


class HelloController extends Controller
{
    public $layout = false;
    public function actionIndex()
    {
    	if (Yii::$app->user->isGuest) {
            return $this->render('auth');
        }
        return $this->render('index');
    }

    public function actionAuth(){

    	if($userobj =  \backend\models\Auth::findByUsername($_POST['username'])){
            if($userobj->password == $_POST['password']){
                if(Yii::$app->user->login($userobj, 0)){
                    return $this->render('index');
                }
            }
    	}
    	return $this->render('auth');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout(true);
        return $this->goHome();
    }
}

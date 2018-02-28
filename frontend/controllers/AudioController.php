<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Audio;


class AudioController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddAudio()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Audio::AddAudio($obj);
        return json_encode($res);
    }

    public function actionAudioLen()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Audio::AudioLen($obj);
        return json_encode($res);
    }

    public function actionAudioTest()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Audio::AudioTest($obj);
        return json_encode($res);
    }

}

?>    
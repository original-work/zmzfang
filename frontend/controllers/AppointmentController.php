<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Appointment;


class AppointmentController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAppointmentOffline()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::AppointmentOffline($obj);
        return json_encode($res);
    }

    public function actionGetAppointment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::GetAppointment($obj);
        return json_encode($res);
    }

    public function actionGetAppointmentStatus()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::GetAppointmentStatus($obj);
        return json_encode($res);
    }

    public function actionDeleteAppointment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::DeleteAppointment($obj);
        return json_encode($res);
    }

    public function actionGetAppointmentAsExpert()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::GetAppointmentAsExpert($obj);
        return json_encode($res);
    }

    public function actionModifyOrderStatus()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::ModifyOrderStatus($obj);
        return json_encode($res);
    }

    public function actionGetAppointmentDetail()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::GetAppointmentDetail($obj);
        return json_encode($res);
    }

    public function actionTestTemplateMessage()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Appointment::TestTemplateMessage($obj);
        return json_encode($res);
    }
}

?>    







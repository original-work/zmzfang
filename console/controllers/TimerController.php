<?php
namespace console\controllers;
 
use Yii;
use yii\console\Controller;
use frontend\models\Appointment;
use frontend\models\Bid;

class TimerController extends Controller
{
	public function actionIndex()
	{
		echo "runnning success\n";
	}

    public function actionTest()
    {
        echo "test\n";
    }

    public function actionAppointmentNotify()
    {
        echo "actionAppointmentNotify\n";
        $res=Appointment::AppointmentNotify();
        return json_encode($res);
    }

    public function actionBidStatus()
    {
        echo "actionBidStatus\n";
        $res=Bid::BidStatus();
        return json_encode($res);
    }
}
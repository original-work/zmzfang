<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Report extends ActiveRecord
{
	public static function tableName()
    {
        return 't_report';
    }

    public static function AddReport($jsonObj)
    {
    		try{
    				$report = new Report();
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
    				$report->userid=$jsonObj->userid;
					$report->nickname=$jsonObj->nickname;
					$report->reporttype=$jsonObj->reporttype;
                    $report->publishuserid=$jsonObj->publishuserid;
                    $report->publishnickname=$jsonObj->publishnickname;
                    $report->requirementid=$jsonObj->requirementid;
                    $report->houseid=$jsonObj->houseid;
                    $report->reportdetail=$jsonObj->reportdetail;
                    $report->createtime=date('y-m-d H:i:s',time());
					$report->save();
    				$arr['rscode']=0;
				    return $arr;

    		} catch(\Exception $e) {
                    Yii::error("ReportPicture::SubmitPicture error is ".$e->getMessage()."\n");
				    return 1;
			} 
    }
    
}

?>
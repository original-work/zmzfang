<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class ReportPicture extends ActiveRecord
{
	public static function tableName()
	{
		return 't_report_picture';
	}
	
 
	public static function SubmitPicture($jsonObj)
	{
		
		try{


			Yii::error("SubmitPicture:jsonObj is : ".print_r($jsonObj,1)."\n");

			$connection = Yii::$app->db;
			if(!$jsonObj->requirementid){
				$clause=" requirementid is null";
			}else{
				$clause=sprintf(" requirementid=%s", $jsonObj->requirementid);
			}

			Yii::error("clause is ".$clause."\n");

			if(!$jsonObj->houseid){
				$clause=sprintf("%s and houseid is null", $clause);
			}else{
				$clause=sprintf("%s and houseid=%s", $clause, $jsonObj->houseid);
			}

			Yii::error("clause is ".$clause."\n");

			$sql = sprintf("SELECT id FROM t_report where userid=%s and reporttype=%s and %s", $jsonObj->userid, $jsonObj->reporttype, $clause);
			Yii::error("sql is ".$sql."\n");

			$reportids = static::findBySql($sql)->asArray()->all();
			// $array = $reportids[0];
			$reportid=$reportids[0][id];

			// foreach($array as $key=>$value)
			// {
			// 	Yii::error($key."=>".$value."\n");
			// 	$reportid=$value;
			// }


			
			Yii::error("reportid is ".$reportid."\n");

			for($i=0; $i<count($jsonObj->picture); $i++)
			{
			    $pic = new ReportPicture();

			    $pic->picture = $jsonObj->picture[$i]->picture;
			    $pic->sn = $jsonObj->picture[$i]->sn;
			    $pic->reportid = $reportid;

			    Yii::error("picture is ".$pic->picture."\n");
			    Yii::error("sn is ".$pic->sn."\n");
			    Yii::error("reportid is ".$pic->reportid."\n");
			    $pic->save();
			}

			$res[reportid]=$reportid;
	        $res[rscode]=0;
	        return $res;
		} catch(\Exception $e) {
			Yii::error("ReportPicture::SubmitPicture error is ".$e->getMessage()."\n");
            return 1;
        }
	}
	
}


?>
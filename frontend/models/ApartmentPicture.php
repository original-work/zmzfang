<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class ApartmentPicture extends ActiveRecord
{
	public static function tableName()
	{
		return 't_house_picture'.CITY;
	}
	
 
	public static function SubmitPicture($jsonObj)
	{
		
		try{
			
			Yii::error("jsonObj is ".print_r($jsonObj,1)."\n");

			$connection = Yii::$app->db;
			$sql = sprintf('SELECT houseid FROM t_house'.CITY.' where userid=%s and expectsaleprice=%s and districtid=%s and storey=%s and roomcnt=%s and hallcnt=%s and bathroomcnt=%s and houseage=%s and buildingtype=%s and decorationtype=%s and orientation=%s and schooldistrictflag=%s and metroflag=%s and owneronlyflag=%s and overfiveonlyflag=%s order by houseid', $jsonObj->userid, $jsonObj->expectsaleprice, $jsonObj->districtid, $jsonObj->storey, $jsonObj->roomcnt, $jsonObj->hallcnt, $jsonObj->bathroomcnt, $jsonObj->houseage, "\"".$jsonObj->buildingtype."\"", "\"".$jsonObj->decorationtype."\"", "\"".$jsonObj->orientation."\"", $jsonObj->schooldistrictflag, $jsonObj->metroflag, $jsonObj->owneronlyflag, $jsonObj->overfiveonlyflag);
			$command = $connection->createCommand($sql);
			$houseid = $command->queryAll();
			$house_count = count($houseid);

			Yii::error("sql is ".$sql."\n");
			Yii::error("houseid is ".print_r($houseid,1)."\n");
			Yii::error("houseid count is ".count($houseid)."\n");
			


			for($i=0; $i<count($jsonObj->picture); $i++)
			{
			    $pic = new ApartmentPicture();
				$pic->houseid = $houseid[count($houseid)-1][houseid];

				Yii::trace("picture[".$i."] is ".print_r($jsonObj->picture[$i],1)."\n");

			    $pic->picture = $jsonObj->picture[$i]->picture;
			    $pic->sn = $jsonObj->picture[$i]->sn;

			    Yii::trace("picture is ".$pic->picture."\n");
			    Yii::trace("sn is ".$pic->sn."\n");
			    Yii::trace("houseid is ".$pic->houseid."\n");
			    $pic->save();
			}

			$res[houseid]=$houseid[count($houseid)-1][houseid];
	        $res[rscode]=0;
	        return $res;
		} catch(\Exception $e) {
			Yii::error("ApartmentPicture::SubmitPicture error is ".$e->getMessage()."\n");
			Supplyment::DelHouseByHouseid($houseid[count($houseid)-1][houseid]);
            return 1;
        }
	}


	public static function DeletePicture($jsonObj)
	{
		try{

			$connection = Yii::$app->db;
			$sql = sprintf("DELETE FROM t_house_picture where houseid=%s ", $jsonObj->houseid);
			Yii::trace("sql is ".$sql."\n");
			$command = $connection->createCommand($sql);
			$houseid = $command->execute();

			return 0;
		} catch(\Exception $e) {
			Yii::error("ApartmentPicture::DeletePicture error is ".$e->getMessage()."\n");
            return 1;
        }
	}



	public static function GetHouseDetail($jsonObj)
    {
        try{
                Yii::trace("request is ".print_r($jsonObj,1)."\n");
                $res = ApartmentPicture::find()->where(['houseid' => $jsonObj->houseid])->orderBy('id')->asArray()->all();
                Yii::trace("res is ".print_r($res,1)."\n");
                return $res;
            } catch(\Exception $e) {
                Yii::error("ApartmentPicture::GetHouseDetail error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
	
}


?>
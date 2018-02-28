<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class YdHouse extends ActiveRecord
{
	public static function tableName()
	{
		return 't_house_yd';
	}
	
	static public function set($obj)
	{
		try{
			if($obj->houseid){
				$m = static::findOne($obj->houseid);
			}else{
				$m = new static;
			}
			$m->userid = $obj->userid;
			$m->region = $obj->region;
			$m->publishdate = date('Y-m-d H:i:s',time());
			$m->updatetime = date('Y-m-d H:i:s',time());
			$m->districtname = $obj->districtname;
			$m->housenumber = $obj->housenumber;
			$m->roomnumber = $obj->roomnumber;
			$m->buildingarea = $obj->buildingarea;
			$m->expectsaleprice = $obj->expectsaleprice;
			$m->storey = $obj->storey;
			$m->totalstorey = $obj->totalstorey;
			$m->roomcnt = $obj->roomcnt;
			$m->hallcnt = $obj->hallcnt;
			$m->bathroomcnt = $obj->bathroomcnt;
			$m->houseage = $obj->houseage;
			$m->buildingtype = $obj->buildingtype;
			$m->decorationtype = $obj->decorationtype;
			$m->orientation = $obj->orientation;
			$m->detail = $obj->detail;
			$m->schooldistrictflag = $obj->schooldistrictflag;
			$m->metroflag = $obj->metroflag;
			$m->owneronlyflag = $obj->owneronlyflag;
			$m->overfiveonlyflag = $obj->overfiveonlyflag;
			$m->pictures = $obj->pictures;

			if($m->save()){
				return ['rscode'=>0,'houseid'=>$m->houseid];
			}else{
				return ['rscode'=>0,'error'=>'system error'];
			}
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}
	static public function get($obj)
	{
		try{
			$where['validflag'] = 1;
			if($obj->region){
				$where['region'] = $obj->region;
			}
			$m = static::find()->where($where)->orderBy(['publishdate'=>SORT_DESC])->limit($obj->limit)->offset($obj->offset)->asArray()->all();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	static public function getListByUserId($obj)
	{
		try{
			$m = static::find()->where(['validflag'=>1,'userid'=>$obj->userid])->asArray()->all();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	static public function detail($obj)
	{
		try{
			$m = static::find()->where(['validflag'=>1,'houseid'=>$obj->houseid])->asArray()->one();
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			$arr['rscode']=1;
			$arr['error']=$e->getMessage();
			return $arr;
		}
	}

	public static function DelHouse($jsonObj){
			try{
				$house = static::find()->where(['houseid'=>$jsonObj->houseid, 'validflag'=>1])->one();
				if($house==null){
					$arr['rscode']=1;
					$arr['error']='house not exist';
					return $arr;
				}
				$house->validflag=0;
				$house->save();
				$arr['rscode']=0;
				return $arr;
				} catch(\Exception $e) {
					Yii::error("YdHouse::DelHouse error is ".$e->getMessage()."\n");
					$arr['rscode']=1;
					$arr['error']=$e->getMessage();
	           	 	return $arr;
       	 	}
	}

	public static function getHouseList($jsonObj){
		$findHouse = static::find()->from('v_house_yd')->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['publishdate'=>SORT_DESC])->asArray()->all();
		return $findHouse;
	}
}

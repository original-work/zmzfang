<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;

class ActivityOrg extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_activity_organization';
	}
	public function detail($p){
		try{
			$m = static::find()->where(['userid'=>$p['userid']])->asArray()->one();
			if(!$m){return ['rscode'=>1,'msg'=>'访问组织不存在'];}
			return ['rscode'=>0,'data'=>$m];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			// return ['rscode'=>1];
			return ['rscode'=>1,'err'=>$e->getMessage()];
		}
	}
	public function add($p){
		try{
			if($om  = static::find()->where(['userid'=>$p['userid']])->one()){
				$om->organization = $p['organization'];
				$om->organizationpic = $p['organizationpic'];
				$om->organizationdetail = $p['organizationdetail'];
				$om->organizationlocation = $p['organizationlocation'];
				$om->contactname = $p['contactname'];
				$om->contactphone = $p['contactphone'];
				$om->updatetime= date('Y-m-d H:i:s',time());
				$om->save();
				return ['rscode'=>0,'id'=>$m->organizationid];
			}
			$m = new static;
			$m->userid = $p['userid'];
			$m->organization = $p['organization'];
			$m->organizationpic = $p['organizationpic'];
			$m->organizationdetail = $p['organizationdetail'];
			$m->organizationlocation = $p['organizationlocation'];
			$m->contactname = $p['contactname'];
			$m->contactphone = $p['contactphone'];
			$m->createtime = $m->updatetime= date('Y-m-d H:i:s',time());
			$m->validflag = 1;
			$m->save();
			return ['rscode'=>0,'id'=>$m->organizationid];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			// return ['rscode'=>1];
			return ['rscode'=>1,'err'=>$e->getMessage()];
		}
	}
	public function modify($p){
		try{
			$m = static::findOne($p['organizationid']);
			if(!$m){return ['rscode'=>1,'msg'=>'访问组织id不存在'];}
			if(!$m->validflag){return ['rscode'=>1,'msg'=>'访问组织id不存在'];}
			$m->userid = $p['userid'];
			$m->organization = $p['organization'];
			$m->organizationpic = $p['organizationpic'];
			$m->organizationdetail = $p['organizationdetail'];
			$m->organizationlocation = $p['organizationlocation'];
			$m->contactname = $p['contactname'];
			$m->contactphone = $p['contactphone'];
			$m->updatetime= date('Y-m-d H:i:s',time());
			$m->save();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			return ['rscode'=>1,'err'=>$e->getMessage()];
			// return ['rscode'=>1];
		}
	}
	public function dele($p){
		try{
			$m = static::findOne($p['organizationid']);
			if(!$m){return ['rscode'=>1,'msg'=>'访问组织id不存在'];}
			$m->delete();
			return ['rscode'=>0];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			// return ['rscode'=>1];
			return ['rscode'=>1,'err'=>$e->getMessage()];
		}
	}

	public function pcAdd($p){
		// var_dump($p);
		try{
			if(!$p['organizationid']){
				$m = new static;
				$m->createtime= date('Y-m-d H:i:s',time());
				$m->validflag= 1;
			}else{
				$m = static::findOne($p['organizationid']);
			}
			$m->userid = $p['userid'];
			$m->organization = $p['organization'];
			$m->organizationpic = $p['organizationpic'];
			$m->organizationdetail = $p['organizationdetail'];
			$m->organizationlocation = $p['organizationlocation'];
			$m->contactname = $p['contactname'];
			$m->contactphone = $p['contactphone'];
			$m->updatetime= date('Y-m-d H:i:s',time());
			$m->save();
			return ['rscode'=>0,'organizationid'=>$m->organizationid];
		}catch(\Exception $e) {
			Yii::error($e->getMessage()."\n");
			// return ['rscode'=>1];
			return ['rscode'=>1,'err'=>$e->getMessage()];
		}
	}
}

?>
<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Advise extends ActiveRecord
{
		public static function tableName()
    {
        return 't_advise';
    }

    public static function submitAdvise($jaonObj)
    {
    		try{
    				$advise=new Advise();
    				$advise->userid=$jaonObj->userid;
						$advise->advisetheme=$jaonObj->advisetheme;
						$advise->advisedetail=$jaonObj->advisedetail;
						$advise->createtime=date('y-m-d H:i:s',time());
						$advise->save();
    				$arr['rscode']=0;
    				$arr['id']=$advise->id;
				    return $arr;
    		} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				} 
    }
    
}

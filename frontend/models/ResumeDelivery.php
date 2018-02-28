<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;
use frontend\models\ResumeEdu;

class ResumeDelivery extends ActiveRecord
{
	public static function tableName()
	{
		return 't_resume_delivery';
	}

	public function getDeliveryId()
    {
        return $this->deliveryid;
    }

	public static function addDelivery($jsonObj)
	{
		try{
			$resume= \frontend\models\Resume::find()->where(['userid'=>$jsonObj->userid])->one();
			//if($resume && $resume->id && $resume-> realname && $resume->city && $resume->workperiod && $resume->phone){
			//}else{return ['rscode'=>1,'message'=>'请将简历填写完整后再试投递'];}

			if($resume)
			{
				if($resume->id && $resume-> realname && $resume->city && $resume->workperiod && $resume->phone)
				{

				}
				else
				{
					return ['rscode'=>1,'message'=>'请将简历填写完整后再试投递'];
				}

				if($resume->resumedetail == '无')
				{
					return ['rscode'=>1,'message'=>'请将简历填写完整，求职附言不能为空'];
				}
			}

			$edu=ResumeEdu::find()->where(['id'=>$resume->id])->one();
			if(empty($edu))
			{
				return ['rscode'=>1,'message'=>'请将简历填写完整，教育经历不能填空'];
			}

			$resumeid = $resume->id;
			$resumedelivery=static::find()->where(['resumeid'=>$resumeid,'recruitid'=>$jsonObj->recruitid])->asArray()->one();
			if($resumedelivery){
				return ['rscode'=>1,'message'=>'您已投递该简历，请耐心等待'];
			}else
			{
				$resumedelivery=new ResumeDelivery();
				$resumedelivery->userid=$jsonObj->userid;
				$resumedelivery->resumeid=$resumeid;
				$resumedelivery->recruitid=$jsonObj->recruitid;
				$resumedelivery->recruituserid=$jsonObj->recruituserid;
				$resumedelivery->delivertime=date('y-m-d H:i:s',time());
				$resumedelivery->validflag=1;
				Yii::error("resumedelivery is ".print_r($resumedelivery,1)."\n");
				$resumedelivery->save();

                $id = $resumedelivery->getDeliveryId();
                Yii::error("addDelivery deliveryid is ".$id."\n");
				static::sendTemplateMessage($resumedelivery->recruituserid,$resumedelivery->resumeid,$resumedelivery->recruitid,$id);
			}
			$arr['rscode']=0;
			return $arr;
		}catch (\Exception $e) {
			Yii::error("ResumeDelivery::addDelivery error is ".$e->getMessage()."\n");
			$arr['rscode']=1;
			return $arr;
		}
	}

	public static function modifyDelivery($jsonObj)
	{
		try{
			Yii::error("modifyResumeDelivery::jsonObj is : ".print_r($jsonObj,1)."\n");

			$resumedelivery=static::find()->where(['deliveryid'=>$jsonObj->deliveryid])->one();
			if(!empty($resumedelivery))
			{
				$resumedelivery->recruitid=$jsonObj->recruitid;
				$resumedelivery->recruituserid=$jsonObj->recruituserid;
				$resumedelivery->deliveryid=$jsonObj->deliveryid;
				$resumedelivery->status=$jsonObj->status;
				$resumedelivery->result=$jsonObj->result;
				Yii::error("modifyResumeDelivery::resumedelivery is ".print_r($resumedelivery,1)."\n");
				$resumedelivery->save();
				$arr['rscode']=0;
				return $arr;
			}else{
				Yii::error("modifyResumeDelivery::deliveryid $jsonObj->deliveryid not exist \n");
				$arr['rscode']=1;
				return $arr;
			}
			
		}catch (\Exception $e) {
			Yii::error("ResumeDelivery::modifyResumeDelivery error is ".$e->getMessage()."\n");
			$arr['rscode']=1;
			return $arr;
		}
	}

	public static function getDelivery($jsonObj)
	{
		try{
            Yii::error("getDelivery::jsonObj is : ".print_r($jsonObj,1)."\n");
            $delivery=static::find()->where(['deliveryid'=>$jsonObj->deliveryid])->andWhere(['validflag'=>1])->andWhere(['recruitid'=>$jsonObj->recruitid])->asArray()->one();
            return $delivery;
        }catch (\Exception $e) {
            Yii::error("Resume::getDelivery error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
	}

	public static function IsDelivery($jsonObj)
	{
		try{
			Yii::error("IsDelivery::jsonObj is : ".print_r($jsonObj,1)."\n");

			$resumedelivery=static::find()->where(['userid'=>$jsonObj->userid])->andWhere(['recruitid'=>$jsonObj->recruitid])->one();
			if(!empty($resumedelivery))
			{
				$arr['rscode']=1;
				return $arr;
			}else{
				Yii::error("IsDelivery::resumeid $jsonObj->resumeid not exist \n");
				$arr['rscode']=0;
				return $arr;
			}
			
		}catch (\Exception $e) {
			Yii::error("ResumeDelivery::IsDelivery error is ".$e->getMessage()."\n");
			$arr['rscode']=1;
			return $arr;
		}
	}

	static function sendTemplateMessage($userid,$resumeid,$recruitid,$deliverid)
    {
        //$userid是收信人，$conten是内容
        $template = array();
        $template['data'] = array();

        Yii::error("sendTemplateMessage: userid is $userid, content is $content\n");

    	$userid=$userid;
    	$fromNickname='芝麻找房';
    	
        $url='http://www.zmzfang.com/weixin/Recruit/ResumeMgr/ResumeDetail.html?resumeId='.$resumeid.'&recruitId='.$recruitid.'&deliveryId='.$deliverid;
    	

		$toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
        Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");


        $content = isset($content)?$content:"简历信息-点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您收到新的简历请查收';
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,$fromNickname,date('Y-m-d',time()),$content];
        $col = [];

        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['wxopenid'];
        $template['url']    = $url;
        Yii::error("template is : ".print_r($template,1)."\n");
        
        if(!empty($toUserInfo['wxopenid'])){
            $Wechatmodel = new Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
        }else{
            $res =[];
        }
        
        return $res;
    }   
	
}

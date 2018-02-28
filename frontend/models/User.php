<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Need;

class User extends ActiveRecord
{   
	public static function tableName()
	{
		return 't_user';
	}
	
	
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id]);
	}
	public static function userInfos($obj)
	{
		foreach($obj as $v){
			if($v<5000){
				$expertArr[]=$v;
			}else{
				$userArr[]=$v;
			}
		}
		$u= [];
		$e= [];
		if($userArr){
			$u = static::find()->select('t_user.id,t_user.nickname,t_user.picture,t_user.validflag as status')->where(['in' ,'id', $userArr])->asArray()->all();
		}
		if($expertArr){
			$e = \frontend\models\Expert::find()->select('id,name as nickname,headpicture as picture,status')->where(['in' ,'id', $expertArr])->asArray()->all();
		}

		return array_merge($u,$e);
	}
	public static function userInfo($obj)
	{
		// var_dump($obj->user);
		// var_dump($obj->user<5000);
		if((int)$obj->user<5000){
			$data = \frontend\models\Expert::find()->select('id,name as nickname,headpicture as picture,status')->where(['id'=>$obj->user])->asArray()->one();
			$data['userType'] = 2;
			return $data;
		}else{
			return $u = static::find()->select('t_user.id,t_user.nickname,t_user.picture,t_user.validflag as status,agentflag as userType')->where(['id'=> $obj->user])->asArray()->one();
		}
	}
	public static function getUserInfo($userid)
	{
		return static::find()->select('t_user.id,t_user.nickname,t_user.phone,t_user.picture,t_user.password,t_user.email,
			t_user.sex,t_user.city,t_user.realname,t_user.agentflag,t_user.identitycard,t_user.expertflag,
			t_user.srcflag,t_user.totaltimes,t_user.logintime,t_user.createtime,t_user.wxopenid AS openid,t_user.wxunionid,
			t_user.tags,t_user.validflag,t_user.max_requirement,t_user.max_supplyment,t_user.havemsg,t_user.activeregion,
			t_expert.id as expertid,t_agent.datacompleterate as datacompleterate')->leftjoin('t_expert','t_user.id = t_expert.userid')->leftjoin('t_agent','t_user.id = t_agent.userid')->where(['t_user.id' => $userid])->asArray()->one();
	}
	
	public static function getUserByOpenid($openid)
	{
			return static::find()->where(['wxopenid' => $openid])->asArray()->one();
	}
	
	public static function modifyUserInfo($jsonData){
			try{               
					$user=static::findIdentity($jsonData->userid);
					if(empty($user)){
							$arr['rscode']=1;
							$arr['error']='用户不存在';
							return $arr;	
					}
					
					if(!empty($jsonData->select))
					{
						$select = implode(',', $jsonData->select);
					}
					else
					{
						$select = '';
					}
					
					if(!empty($jsonData->phone)){
						$user_phone=static::findOne(['phone' => $jsonData->phone]);

						if(!empty($user_phone)){
							if($user_phone->phone!=$user->phone){
								if($user_phone->id <10000){
									$connection = Yii::$app->db;
									$sql = sprintf("UPDATE t_requirement set publishuserid= %s where  publishuserid = %s;",$jsonData->userid , $user_phone->id);
										$command = $connection->createCommand($sql);
										$command->execute();
										$connection->createCommand(sprintf("UPDATE t_user set phone = '' where id = %s", $user_phone->id))->execute();
								}else{
									$arr['rscode']=1;
									$arr['error']='手机号已经被注册';
									return $arr;
								}
							}
						}

						$user->phone=$jsonData->phone;
					}
					
					if($user->agentflag==1){
						$user->max_requirement=1;
						$user->max_supplyment=5;
					}else{
						$user->max_requirement=1;
						$user->max_supplyment=2;
					}

					$user->nickname=$jsonData->nickname;
					$user->picture=$jsonData->picture;
					$user->email=$jsonData->email;
					$user->sex=$jsonData->sex;
					$user->city=$jsonData->city;
					$user->realname=$jsonData->realname;
					$user->identitycard=$jsonData->identitycard;
					$user->tags=$select;
					$user->agentflag=$jsonData->agentflag;
					$user->activeregion=$jsonData->activeregion;
					$user->save();
					$arr['rscode']=0;
					return $arr;
				} catch(\Exception $e) {
					$arr['rscode']=1;
					$arr['error']=$e->getMessage();
					return $arr;
				}
	}
	
	public static function addFavoriteRequirement($jsonData){
			return FavoriteRequirement::addFavoriteRequirement($jsonData->userid,$jsonData->requirementid);
	}
	
	public static function getFavoriteRequirement($userid){
			return FavoriteRequirement::getUserFavoriteRequirement($userid);
	}
	
	public static function deleteFavoriteRequirement($jsonData){
			return FavoriteRequirement::deleteFavoriteRequirement($jsonData->userid,$jsonData->requirementid);
	}
	
	public static function findUserByPhone($phone)
	{
			return static::findOne(['phone' => $phone]);
	}
	
	public static function register($jsonData)
	{
			try{
					$user=static::findUserByPhone($jsonData->phone);
					if(!empty($user)){
							$arr['rscode']=1;
							$arr['error']='用户已经存在';
							return $arr;
					}
					
					$user = new User();
				$user->phone = $jsonData->phone;
				$user->password = $jsonData->passwd;
						$user->logintime=date('y-m-d H:i:s',time());
						$user->createtime=date('y-m-d H:i:s',time());
				$user->save();
				$arr['rscode']=0;
				$arr['id']=$user->id;
					  return $arr;
				} catch(\Exception $e) {
					$arr['rscode']=1;
					$arr['error']=$e->getMessage();
					return $arr;
				}
	}
	
	public function login($jsonData){		
			  if($this->password==$jsonData->passwd){
				$arr['rscode']=0;
				$arr['userid']=$this->id;
					  return $arr;
				} else {
						$arr['rscode']=1;
					$arr['error']='密码不正确';
					return $arr;	
				}
	}



	public static function registerWeixin($jsonData)
	{
			try{
					$user=static::findUserByPhone($jsonData->phone);
					if(!empty($user)){
							$arr['rscode']=1;
							$arr['userid']=$user->id;
							$arr['error']=$e->getMessage();
							return $arr;
					}
					
					$user = new User();
					$user->nickname = $jsonData->nickname;
					$user->phone = $jsonData->phone;
					$user->picture=$jsonData->picture;
					$user->password=$jsonData->password;
					if($jsonData->password!=$jsonData->confirmpasswd){
							$arr['rscode']=1;
							$arr['userid']=$user->id;
							$arr['error']="password inconsistent";
							return $arr;
					}
					
					$user->email = $jsonData->email;
					$user->sex=$jsonData->sex;
					$user->city=$jsonData->city;
					$user->realname=$jsonData->realname;
					$user->agentflag = $jsonData->agentflag;
					$user->identitycard = $jsonData->identitycard;
					$user->expertflag=$jsonData->expertflag;
					$user->srcflag=$jsonData->srcflag;
					$user->wxopenid=$jsonData->wxopenid;
					$user->wxunionid=$jsonData->wxunionid;
					$user->tags=$jsonData->tags;

					$user->save();
					$arr['rscode']=0;
					$arr['userid']=$user->id;
					
					return $arr;
				} catch(\Exception $e) {
					$arr['rscode']=1;
					$arr['userid']=$user->id;
					$arr['error']=$e->getMessage();
					
					return $arr;
				}
	}


	public static function publishHouse($rawData){
			$jsonData = json_decode($rawData);
			$res1 = Supplyment::SubmitHouse($jsonData);
			
			if(1==$res1['code']){
				$arr[rscode]=1;
				return $arr;
			}
		  
			$res2 = ApartmentPicture::SubmitPicture($jsonData);
			if(1==$res2){
				$arr[rscode]=1;
				return $arr;
			}else{
				$options['userid'] = $jsonData->userid;
				$options['type'] = 30;
				$options['dstid'] = $res2['houseid'];
				$options['dstuserid'] = 0;
 				$options['city'] = empty($obj->city)?'上海市':$obj->city;
				UserOperate::addUserLog($options);
				return $res2;
			}
	}


	public static function addReport($rawData){
			$jsonData = json_decode($rawData);
			$res1 = Report::AddReport($jsonData);
			if(1==$res1){
				$arr[rscode]=1;
				return $arr;
			}
			$res2 = ReportPicture::SubmitPicture($jsonData);
			if(1==$res2){
				$arr[rscode]=1;
				return $arr;
			}else{
				
				return $res2;
			}
	}

	public static function modifyHouse($rawData){
			$jsonData = json_decode($rawData);
			$res1 = Supplyment::ModifyHouse($jsonData);
			if(1==$res1){
				return 1;
			}
			$res2 = ApartmentPicture::DeletePicture($jsonData);
			if(1==$res2){
				return 1;
			}
			$res3 = ApartmentPicture::SubmitPicture($jsonData);
			if(1==$res3){
				return 1;
			}else{
				$options['userid'] = $jsonData->userid;
				$options['type'] = 31;
				$options['dstid'] = $jsonData->houseid;
				$options['dstuserid'] = $jsonData->userid;
 				$options['city'] = empty($obj->city)?'上海市':$obj->city;
				UserOperate::addUserLog($options);
				return 0;
			}
	}


	public static function GetUserLimit($jsonData)
	{
		try{
				Yii::error("jsonData is ".print_r($jsonData,1)."\n");
				$user=static::find()->where(['id' => $jsonData->userid])->one();
				Yii::error("user is ".print_r($user,1)."\n");
				if(empty($user)){
					$arr['rscode']=1;
					$arr['userid']=$user->id;
					$arr['error']="no such user";
					return $arr;
				}
				$user->email = $jsonData->email;
				$arr['rscode']=0;
				$arr['max_requirement']=$user->max_requirement;
				$arr['max_supplyment']=$user->max_supplyment;
				return $arr;
			} catch(\Exception $e) {
				$arr['rscode']=1;
				$arr['userid']=$user->id;
				$arr['error']=$e->getMessage();
				return $arr;
			}
	}



	static function isNeedSms($userid){
		$model = new User();
		$userInfo = $model::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
		if(!empty($userInfo['wxopenid'])){
			/* 判断是否订阅用户，更新wxunionid */
			// $wxUserInfo = \common\models\Wechat::getSubscribeInfo($userInfo['wxopenid']);
			// if($wxUserInfo['subscribe']){
			//     if(empty($userInfo['wxunionid'])){
			//         $model->wxunionid = $wxUserInfo['unionid'];
			//         $model->save();
			//         return ['openid'=>$userInfo['wxopenid'],'nickname'=>$userInfo['nickname']];//已订阅我们
			//     }
			// }else{
			//     //发送sms 未订阅我们
			//     return ['phone'=>$userInfo['phone'];
			// }
			return ['openid'=>$userInfo['wxopenid'],'nickname'=>$userInfo['nickname'],'phone'=>$userInfo['phone']];
		}else{
			//发送sms openid未绑定
			return ['nickname'=>$userInfo['nickname'],'phone'=>$userInfo['phone']];
		}
	}

}

?>
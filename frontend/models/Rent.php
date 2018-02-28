<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;

class Rent extends ActiveRecord
{
		public static function tableName()
	    {
	        return 't_requirement_rent'.CITY;
	    }
	    public static function addRent($jsonObj)
	    {
	    	try{
	    		$session = Yii::$app->session;
		        $mid = $session->get('msgid');
		        if($jsonObj->mid == $mid){
		              return ['rscode'=>1];
		        }else{
		            $mid = $session->set('msgid',$jsonobj->mid);
		        }
					$requirement = new static();
					$requirement->publishuserid=$jsonObj->publishuserid;
					$requirement->publishusertype=$jsonObj->publishusertype;
					$requirement->requirementtype=$jsonObj->requirementtype;
					
					
					$requirement->budget=$jsonObj->budget;
					$requirement->housetype=$jsonObj->housetype;
					$requirement->storey=$jsonObj->storey;
					$requirement->buildingtype=$jsonObj->buildingtype;
					$requirement->detail=$jsonObj->detail;
					/* 暂时不考虑佣金
					$requirement->acceptagentflag=$jsonObj->acceptagentflag;
					$requirement->agentfee=$jsonObj->agentfee;
					$requirement->dividerate=$jsonObj->dividerate;
					$requirement->expectdividefee=$jsonObj->expectdividefee;
					$requirement->dividefeedescribe=$jsonObj->dividefeedescribe;
					*/
					$requirement->updatetime=date('y-m-d H:i:s',time());
					$requirement->createtime=$requirement->updatetime;
					$requirement->subject = $jsonObj->subject;
					$requirement->city = $jsonObj->city;

					if($requirement->requirementtype==1){
						$requirement->region1=$jsonObj->region1;
						$requirement->region2=$jsonObj->region2;
						$requirement->region3=$jsonObj->region3;
						$parameter = ['region1','region2','region3'];
						foreach ($parameter as $value) {
							if(!empty(trim($jsonObj->$value))){
								$in[] = $jsonObj->$value;
							}
						}
						$r = substr($jsonObj->region1,0,2);
						switch ($r) {
							case '11':
								// if 地铁
								
								$where['value'] = $in;
								$regionsSearch = \frontend\models\Metro::find()->select('region')->where($where)->asArray()->all();
								// var_dump($regionsSearch);
								foreach($regionsSearch as $regions){
									$regionsArray[]=$regions['region'];
								}
								foreach($regionsArray as $toArea){
									$toAreas[]=substr($toArea,0,4).'00';
								}
								$regionsUniqueArray = array_unique($toAreas);
								$requirement->regions = implode(',', $regionsUniqueArray);
								// 字符串转换成一级区域
								// 再转换成数组 
								// 去除重复项，组成新数组
								break;
							case '12':
								//if 学区
								exit;
							case '13':
								//if 区域
								foreach ($in as $regions) {
									$regionsArray[]=substr($regions,0,4).'00';
								}
								$regionsUniqueArray = array_unique($regionsArray);
								$requirement->regions = implode(',', $regionsUniqueArray);
								break;
						}
						
					} else {
						$requirement->districtid=$jsonObj->districtid;
						$requirement->districtname=$jsonObj->districtname;
						$regionsSearch = \frontend\models\ResidentialInfo::findOne($requirement->districtid);
						$requirement->regions = '13'.$regionsSearch['region'].'00';
				  	}

				  	// var_dump($requirement->regions);
					$requirement->save();
					$arr['rscode']=0;
			    	$arr['id']=$requirement->id;
			    	return $arr;
				} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				}
    	}
    	public static function getRentList($jsonObj)
    	{
    		$model = static::find()->from('v_requirement_rent');
    		$region = substr($jsonObj->region,0,4).'__';
    		if(substr($jsonObj->region,0,2)==11){
				$model->where(['or',['or',['like','region1',$region,false],['like','region2',$region,false]],['like','region3',$region,false]]);

			}elseif(substr($jsonObj->region,0,2)==13){
				$model->where("FIND_IN_SET('".$jsonObj->region."',regions)");
			}
        	if($jsonObj->housetype){  //按照室查询
        		$model->andWhere(['housetype'=>$jsonObj->housetype]);
        	}
        	if($jsonObj->pricerange){  /*按照价格查询 入参确认*/
        		$model->andWhere(['budget'=>$jsonObj->pricerange]);
        	}
        	$model->andWhere(['validflag'=>1]);
        	
        	return $model->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        	// $test = $model->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->createCommand();//测试用 查看sql
        	// return [$test->sql,$test->params];
        }
        public static function getRentListByUserid($jsonObj)
        {
        	$sql='SELECT id AS requirementid, publishuserid AS  userid, subject, budget AS price,housetype,IFNULL(bidcnt,0) AS bidcnt,updatetime AS publishdate,createtime AS createdate,city FROM t_requirement_rent'.CITY.' as requirement  LEFT OUTER JOIN   (SELECT requirementid,COUNT(requirementid) AS bidcnt FROM t_house_bid where bidtype = 3 GROUP BY requirementid) AS t_bidcnt ON t_bidcnt.requirementid=requirement.id  LEFT OUTER JOIN (SELECT agentflag, id AS userid FROM t_user GROUP BY userid) AS xx ON xx.userid=requirement.publishuserid WHERE requirement.publishuserid='.$jsonObj->userid.' AND requirement.validflag=1 limit '.$jsonObj->start.','.$jsonObj->count;
				Yii::trace("getRequirementList: ".$sql);
				return static::findBySql($sql)->asArray()->all();
        }
        public static function getRentDetail($jsonObj)
        {
        	if(empty($jsonObj->city))
        	{
        		$city = '上海市';
        	}
        	else
        	{
        		$city = $jsonObj->city;
        	}					
        	return $model = static::find()->from('v_requirement_rent')->where(['id'=>$jsonObj->rentid,'city'=>$city,'validflag'=>1])->asArray()->one();
        }
        public static function updateRent($jsonObj)
    	{
    		$model = static::findOne($jsonObj->rentid);
    		$model->budget =       $jsonObj->budget;
    		$model->housetype =       $jsonObj->housetype;
    		$model->storey =       $jsonObj->storey;
    		$model->buildingtype =       $jsonObj->buildingtype;
    		$model->detail =       $jsonObj->detail;
    		$model->updatetime = date('Y-m-d H:i:s',time());
    		if($model->save()){
	            return ['rscode'=>0];
	        }else{
	            return ['rscode'=>1];
	        }
    	}

    	public static function deleteRent($jsonObj)
    	{
	        $model = static::findOne(['id'=>$jsonObj->rentid,'publishuserid'=>$jsonObj->userid]);
	        $model->validflag = 0;
	        if($model->save()){
	            return ['rscode'=>0];
	        }else{
	            return ['rscode'=>1];
	        }
	    }
        public static function getBidinfoByRentid($jsonObj)
        {
        	$model = \frontend\models\Bid::find()->select('t_house_bid.biduserid as userid,t_house_bid.biddate,t_user.picture as userpicture,t_user.nickname as username,t_user.agentflag as agentflag')->leftjoin('t_user','t_house_bid.biduserid =t_user.id')->where(['requirementid'=>$jsonObj->rentid,'bidtype'=>3,'t_house_bid.city'=>$jsonObj->city])->asArray();
        	if($jsonObj->limit){
        		$data = $model->limit($jsonObj->limit)->orderBy(['biddate'=>DESC])->all();
        	}else{
        		$data = $model->orderBy(['biddate'=>DESC])->all();
        	}
        	$count = \frontend\models\Bid::find()->from('t_house_bid')->where(['requirementid'=>$jsonObj->rentid,'bidtype'=>3,'t_house_bid.city'=>$jsonObj->city])->count();
        	if($data){
        		// $test = \frontend\models\User::find()->select('id as userid,picture as userpicture,nickname as username')->where(['in', 'id', $biduserids])->asArray()->createCommand();//测试用 查看sql
        		// return [$biduserids,$biduseridArray,$test->sql,$test->params];
        		$userchars['data'] = $data;
        		$userchars['count'] = $count;
        		return $userchars;
        	}else{
        		return [];
        	}
        }

   		public static function flushRentRequirement($jsonObj){
   			$model = static::findOne($jsonObj->rentid);
   			$model -> updatetime = date('Y-m-d H:i:s',time());
   			if($model->save()){
	            return ['rscode'=>0];
	        }else{
	            return ['rscode'=>1];
	        }
   		}


   		public static function PushRent($jsonObj){
			Yii::error("Rent::PushRent jsonObj is ".print_r($jsonObj,1)."\n");
			//先根据需求id获取到需求详情，然后查找t_requirement_rent记录里面的 region1 字段
			$rent = static::find()->where(['id'=>$jsonObj->rentid, 'validflag'=>1])->one();
			Yii::error("rent is ".print_r($rent,1)."\n");

			//增加不向同公司同事推送的逻辑
			//获取发布所属的公司---经纪人
			$publishAgentOrganization = null;
			$publishAgentInfo = Agent::findIdentity($rent->publishuserid);
			if(!empty($publishAgentInfo) && !empty($publishAgentInfo->organization))
			{
				$publishAgentOrganization = $publishAgentInfo->organization;
			}

			$regions=null;
			$user=null;
			
			//如果有该字段，则是按照区域发布的，区域分11地铁和13板块两种
			if($rent->region1|$rent->region2|$rent->region3){
				$f2=substr($rent->region1,0,2);
				if($rent->region1){
					$regions[0]=$rent->region1;
				}
				if($rent->region2){
					$regions[1]=$rent->region2;
				}
				if($rent->region3){
					$regions[2]=$rent->region3;
				}
				Yii::error("f2 is $f2\n");
				//如果是13开头的，那么板块ID就是 region1,region2,region3字段的值
				if($f2=='13'){
					foreach ($regions as $region){
						$connection = Yii::$app->db;
						$sql='SELECT * FROM v_agent WHERE FIND_IN_SET('.$region.',activeregion)';

						//除限制区域外增加，其他限制，如不发给同公司的同事
						static::pushRequirementToUser($publishAgentOrganization,$jsonObj->rentid,$rent->publishuserid,$sql);

						/**
						$command = $connection->createCommand($sql);
                		$users = $command->queryAll();
                		Yii::error("Rent::PushRent users are ".print_r($users,1)."\n");
                		//发送模板消息
                		foreach ($users as $user) {
                			static::sendTemplateMessage($user['id'],$rent->publishuserid,$content,$jsonObj->rentid);
                		}
                		**/
					}
				}elseif($f2=='11'){//如果是11开头的，那么是按照地铁发布的，到 t_metro 表里面去查找，region1,region2,region3 的值对应value字段的值，找到对应记录后取出region字段作为板块ID。
					foreach ($regions as $region){
						$connection = Yii::$app->db;
						$sql='SELECT region FROM t_metro WHERE value='.$region;
						$command = $connection->createCommand($sql);
                		$metro_regions = $command->queryAll();

                		foreach ($metro_regions as $metro_region){
                    		$sql='SELECT * FROM v_agent WHERE FIND_IN_SET('.$region.',activeregion)';
							//除限制区域外增加，其他限制，如不发给同公司的同事
							static::pushRequirementToUser($publishAgentOrganization,$jsonObj->rentid,$rent->publishuserid,$sql);

                    		/**
							$command = $connection->createCommand($sql);
                    		$users = $command->queryAll();
                    		Yii::error("Rent::PushRent users are ".print_r($users,1)."\n");
                    		//发送模板消息
                    		foreach ($users as $user) {
                    			static::sendTemplateMessage($user['id'],$rent->publishuserid,$content,$jsonObj->rentid);
                    		}
                    		**/
                		}
					}
				}else{
					Yii::error("xxxxxxxxxx\n");
				}
			}else{//如果没有这三个字段则是按照小区发布的，取districtid值，然后到 t_residential_district 表去取 region和plate字段，组成 板块ID。
				Yii::error("33333333333\n");
				$connection = Yii::$app->db;
				$sql='SELECT * FROM t_residential_district WHERE districtid=$rent->districtid';
				$command = $connection->createCommand($sql);
        		$residential_district = $command->queryAll();
        		$region='13'.$residential_district[0]['region'].$residential_district[0]['plate'];
        		$sql='SELECT * FROM v_agent WHERE FIND_IN_SET('.$region.',activeregion)';

				//除限制区域外增加，其他限制，如不发给同公司的同事
				static::pushRequirementToUser($publishAgentOrganization,$jsonObj->rentid,$rent->publishuserid,$sql);

        		/**
				$command = $connection->createCommand($sql);
        		$users = $command->queryAll();
        		Yii::error("Rent::PushRent users are ".print_r($users,1)."\n");
        		////发送模板消息
        		foreach ($users as $user) {
        			static::sendTemplateMessage($user['id'],$rent->publishuserid,$content,$jsonObj->rentid);
        		}
        		**/
			}
    		
    		$arr['recode']=0;
	    	return $arr;
		}

		static function pushRequirementToUser($publishAgentOrganization,$requirementid,$publishuserid,$findusersql)
		{
			$content='您的区域有新的求租需求请查看';
			$connection = Yii::$app->db;
			$sql = $findusersql;
			//增加不向同公司同事推送的逻辑 begin
			if(!empty($publishAgentOrganization) && $publishAgentOrganization != '')
			{
				$sql .= ' and organization not like \'%';
				$sql .= $publishAgentOrganization;
				$sql .= '%\'';
			}
			Yii::error("Requirement::PushRequirement sql is".print_r($sql,1)."\n");
			//增加不向同公司同事推送的逻辑 end

			$command = $connection->createCommand($sql);
			$users = $command->queryAll();
    		Yii::error("Requirement::PushRequirement users are ".print_r($users,1)."\n");
    		////发送模板消息
    		foreach ($users as $user) {
    			static::sendTemplateMessage($user['userid'],$publishuserid,$content,$requirementid);
    		}

		}


		static function sendTemplateMessage($userid,$publishuserid,$content,$rentid)
	    {
	        //$userid是收信人，$publishuserid是发信人就是需求发布者，$conten是内容，$rentid是需求ID
	        $template = array();
	        $template['data'] = array();

	        Yii::error("sendTemplateMessage: userid is $userid, publishuserid is $publishuserid, content is $content,
	            orderid is $orderid\n");

	    	$userid=$userid;
	    	$fromNickname='芝麻找房';
	    	
	        $url='http://www.zmzfang.com/weixin/HomePage/RentRequirementDetail.html?requirementId='.$rentid.'&userId='.$publishuserid;
	    	Yii::error("case 1: userid is $userid, fromNickname is $fromNickname, url is $url\n");

			$toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
	        Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");


	        $content = isset($content)?$content:"点击下方查看详情";
	        $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的消息请查收';
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
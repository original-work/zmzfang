<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\Need;
use common\models\Wechat;
use frontend\models\Agent;
use common\utils\CommonFun;

class Requirement extends ActiveRecord
{
	public static function tableName()
    {
        return 't_requirement'.CITY;
    }
	
    public function getNeeds($id)
    {

        if (!$this->validate()) {
            var_dump($model->getErrors());
        }
        
        if($res = static::findOne(["id"=>$id, 'validflag' => 1])){
            return $res;
        }else{
            return null;
        }
        
    }
    public function getNewLists($limit,$areaid,$price,$housetype)
    {
        if (!$this->validate()) {
            var_dump($model->getErrors());
        }
        $condition = array();
        $need = new Need();
        if(isset($areaid)):
            $condition['region1'] = $areaid;
        endif;
        if(isset($price)):
            $condition['budget'] = $price;
        endif;
        if(isset($housetype)):
            $condition['housetype'] = $housetype;
        endif;
        $condition['validflag'] = 1;
        if($res = $need::find()->where($condition)->limit($limit)->orderBy('id')->all()){
            return $res;
        }else{
            return null;
        }
        
    }
    public function Submit($id)
    {
        if (!$this->validate()) {
            var_dump($model->getErrors());
        }
        $res = false;
        $condition = array();
        $need = new Requirement();
        /*****
        $model->load(Yii::$app->request->post();
        ***/
        if(isset($id)){
            $condition['id'] = $id;
            $condition['validflag'] = 1;
            $need = Requirement::findOne($condition);
            $need->publishuserid = $id;
            $res = true;
        }else{
            $need->publishuserid = 3;
            $need->publishusertype = 3;
            $need->requirementtype = 3;
            $need->region1 = 3;
            $need->region2 = 3;
            $need->region3 = 3;
            $need->districtid = 3;
            $need->districtname = 3;
            $need->budget = 3;
            $need->housetype = 3;
            $need->storey = 3;
            $need->buildingtype = 3;
            $need->detail = 3;
            $need->acceptagentflag = 3;
            $need->agentfee = 3;
            $need->dividefeedescribe = 3;
            $need->updatetime = 3;
            $need->createtime = 3;
        }
        $need->save();
        return $res;
        
    }
    public function getMyNeeds($userid)
    {
        if (!$this->validate()) {
            var_dump($model->getErrors());
        }

        $need = new Need();
        $res = $need -> getMyNeed($userid);
        return $res;
    }
    
    public static function getRequirementList($jsonObj)
	{
		// $parameter = ['housetype','budget'];

		// foreach ($parameter as $value) {
		// 	if(!empty(trim($jsonObj->$value))){
		// 		$where .= " AND t_requirement.".$value."= :".$value;
		// 		$params[':'.$value] =$jsonObj->$value;
		// 	}
		// }
		// if(substr($jsonObj->region,0,2)==11){
		// 	$where .= " AND (t_requirement.region1 like :region  or t_requirement.region2 like :region or t_requirement.region3 like :region )";
		// 	$params[':region'] = substr($jsonObj->region,0,4)."__";

		// }elseif(substr($jsonObj->region,0,2)==13){
		// 	$where .= " AND FIND_IN_SET(:region2,t_requirement.regions)";
		// 	$params[':region2'] = $jsonObj->region;
		// }
		// $params[':start'] = $jsonObj->start;
		// $params[':count'] = intval($jsonObj->count);

		// return $post = Yii::$app->db->createCommand('SELECT `t_requirement`.*, `t_user`.`nickname`, `t_user`.`picture`, `t_user`.`agentflag` FROM `t_requirement` LEFT JOIN `t_user` ON t_user.id = t_requirement.publishuserid WHERE ((`t_requirement`.`validflag`= 1) AND (`t_user`.`validflag`=1))'.$where.' order by t_requirement.updatetime desc limit :count offset :start')
		//            ->bindValues($params)
		//            ->queryAll();
		// return $post->sql;

		
		// Yii::error("getRequirementList: ".$sql);
		// return static::findBySql($sql)->asArray()->all();

		$model = static::find()->from('v_requirement');
		$region = substr($jsonObj->region,0,4).'__';
		if(substr($jsonObj->region,0,2)==11){
			$model->where(['or',['or',['like','region1',$region,false],['like','region2',$region,false]],['like','region3',$region,false]]);

		}elseif(substr($jsonObj->region,0,2)==13){
			$model->where("FIND_IN_SET('".$jsonObj->region."',regions)");
		}
		if($jsonObj->housetype){  //按照室查询
		    $model->andWhere(['housetype'=>$jsonObj->housetype]);
		}
		if($jsonObj->pricerange){  /*按照价格查询 入参确认 不限暂用 0-49999*/
		    $model->andWhere(['budget'=>$jsonObj->pricerange]);
		}
		$model->andWhere(['validflag'=>1]);
		        	
		return $model->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
		// $test = $model->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->createCommand();//测试用 查看sql
		// return [$test->sql,$test->params];
	}
		
		public static function getRequirement($requirementid){
				return static::find()->where(['id'=>$requirementid, 'validflag'=>1])->one();
		}
		
		public static function modifyRequirement($jsonObj){
			  $requirement=static::getRequirement($jsonObj->id);
				try{
						if(empty($requirement)){
							$arr['rscode']=1;
				    		$arr['error']='需求不存在';
				    		return $arr;
						}
						Yii::error("requirement is ".print_r($jsonObj,1)."\n");
						$requirement->publishuserid=$jsonObj->publishuserid;
						$requirement->publishusertype=$jsonObj->publishusertype;
						$requirement->requirementtype=$jsonObj->requirementtype;
						$requirement->region1=$jsonObj->region1;
						$requirement->region2=$jsonObj->region2;
						$requirement->region3=$jsonObj->region3;
						$requirement->districtid=$jsonObj->districtid;
						$requirement->districtname=$jsonObj->districtname;
						$requirement->budget=$jsonObj->budget;
						$requirement->housetype=$jsonObj->housetype;
						$requirement->storey=$jsonObj->storey;
						$requirement->buildingtype=$jsonObj->buildingtype;
						$requirement->detail=$jsonObj->detail;
						$requirement->acceptagentflag=$jsonObj->acceptagentflag;
						$requirement->agentfee=$jsonObj->agentfee;
						$requirement->dividerate=$jsonObj->dividerate;
						$requirement->expectdividefee=$jsonObj->expectdividefee;
						$requirement->dividefeedescribe=$jsonObj->dividefeedescribe;
						$requirement->updatetime=date('y-m-d H:i:s',time());
						/*
						if($requirement->requirementtype==1){
								$requirement->subject=$jsonObj->region2.$jsonObj->region3;
						} else {
							  $requirement->subject=$requirement->districtname;
					    }
					    */
						$requirement->save();
						
						$arr['rscode']=0;
				    return $arr;
						
				} catch(\Exception $e) {
					Yii::error("error is: ".$e->getMessage());
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				}
		}
		public static function addRequirement($jsonObj)
		{
				try{
					$session = Yii::$app->session;
			        $mid = $session->get('msgid');
			        if($jsonObj->mid == $mid){
			              return ['rscode'=>1];
			        }else{
			            $mid = $session->set('msgid',$jsonobj->mid);
			        }
						$requirement = new Requirement();
						$requirement->publishuserid=$jsonObj->publishuserid;
						$requirement->publishusertype=$jsonObj->publishusertype;
						$requirement->requirementtype=$jsonObj->requirementtype;
						
						$requirement->districtid=$jsonObj->districtid;
						$requirement->districtname=$jsonObj->districtname;
						$requirement->budget=$jsonObj->budget;
						$requirement->housetype=$jsonObj->housetype;
						$requirement->storey=$jsonObj->storey;
						$requirement->buildingtype=$jsonObj->buildingtype;
						$requirement->detail=$jsonObj->detail;
						$requirement->acceptagentflag=$jsonObj->acceptagentflag;
						$requirement->agentfee=$jsonObj->agentfee;
						$requirement->dividerate=$jsonObj->dividerate;
						$requirement->expectdividefee=$jsonObj->expectdividefee;
						$requirement->dividefeedescribe=$jsonObj->dividefeedescribe;
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

		public static function addRequirementByCity($jsonObj)
		{
				try{
					$session = Yii::$app->session;
			        $mid = $session->get('msgid');
			        if($jsonObj->mid == $mid){
			              return ['rscode'=>1];
			        }else{
			            $mid = $session->set('msgid',$jsonobj->mid);
			        }

			        $time=date('y-m-d H:i:s',time());
			        $city = $jsonObj->city;
                	$cityno = CommonFun::getCityNoByCityName($city);
			        $tbname = 't_requirement_'.$cityno;
			        $regions = ' ';
                    $sql = sprintf("INSERT INTO %s (publishuserid,publishusertype,requirementtype,region1,region2,region3,
                    	regions,districtid,districtname,budget,housetype,storey,
                    	buildingtype,detail,acceptagentflag,agentfee,dividefeedescribe,updatetime,
                    	createtime,dividerate,expectdividefee,subject,validflag) 
                        VALUES ( 
                        	%s, %s, %s, '%s', '%s', '%s',
                        	'%s', '%s', '%s', '%s', '%s', '%s',
                        	'%s', '%s', %s, %s, '%s', '%s',
                        	 '%s', '%s', %s,'%s',1)",
                    		$tbname, 
                    		$jsonObj->publishuserid,$jsonObj->publishusertype,$jsonObj->requirementtype,$jsonObj->region1,$jsonObj->region2,$jsonObj->region3,
                        	$regions,$jsonObj->districtid,$jsonObj->districtname,$jsonObj->budget,$jsonObj->housetype,$jsonObj->storey,
                        	$jsonObj->buildingtype,$jsonObj->detail,$jsonObj->acceptagentflag,$jsonObj->agentfee,$jsonObj->dividefeedescribe,$time,
                        	$time,$jsonObj->dividerate,$jsonObj->expectdividefee,$jsonObj->subject);

                    Yii::error("sql is ".$sql."\n");
                    $connection = Yii::$app->db;
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    $sql = sprintf("select id from %s where publishuserid = %s and 
                    	publishusertype = %s and requirementtype=%s and createtime='%s'",$tbname,
                    	$jsonObj->publishuserid,$jsonObj->publishusertype ,$jsonObj->requirementtype,$time);
					$command = $connection->createCommand($sql);
                    $requirement = $command->queryAll();
                    $requirement_count = count($requirement);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("requirement count is ".$requirement_count."\n");
                    Yii::error("requirement[0] is ".print_r($requirement[0],1)."\n");
                    $id=$requirement[0][id];


					$arr['rscode']=0;
			    	$arr['id']=$id;
			    	return $arr;
				} catch(\Exception $e) {
				    $arr['rscode']=1;
				    $arr['error']=$e->getMessage();
				    return $arr;
				}

		}
		
		public static function getUserRequirements($userid){
				$sql='SELECT id AS requirementid, publishuserid AS  userid, subject, agentfee, budget AS price,housetype,IFNULL(bidcnt,0) AS bidcnt,updatetime AS publishdate,createtime AS createdate,city FROM t_requirement'.CITY.' as requirement LEFT OUTER JOIN   (SELECT requirementid,COUNT(requirementid) AS bidcnt FROM t_house_bid where bidtype = 1 GROUP BY requirementid) AS t_bidcnt ON t_bidcnt.requirementid=requirement.id  LEFT OUTER JOIN (SELECT agentflag, id AS userid FROM t_user GROUP BY userid) AS xx ON xx.userid=requirement.publishuserid WHERE requirement.publishuserid='.$userid.' AND requirement.validflag=1';
				Yii::error("getRequirementList: ".$sql);
				return static::findBySql($sql)->asArray()->all();	
		}


		public static function Search($jsonObj)
	    {
	        try{
	                Yii::trace("request is ".print_r($jsonObj,1)."\n");
	                Yii::trace("jsonObj->key is ".$jsonObj->key."\n");

	                $res = Requirement::find()->where(['like', 'districtname', $jsonObj->key])->andWhere(['validflag'=>1])->orderBy('districtid')->asArray()->all();
	                Yii::trace("res is ".print_r($res,1)."\n");
	                return $res;
	            } catch(\Exception $e) {
	                Yii::error("Requirement::Search error is ".$e->getMessage()."\n");
	                return $e->getMessage();
	            }
	    }


	    public static function GetRequirementByDistrictid($jsonObj){
				$res = static::find()->where(['districtid'=>$jsonObj->districtid, 'validflag'=>1])->asArray()->orderBy('id')->all();
				Yii::trace("res is ".print_r($res,1)."\n");
				return $res;
		}

		public static function DelRequirementByRequirementid($jsonObj){
			try{
				$requirement = static::find()->where(['id'=>$jsonObj->requirementid, 'validflag'=>1])->one();
				if($requirement==null){
					$arr['rscode']=1;
					$arr['error']='requirement not exist';
					return $arr;
				}
				$requirement->validflag=0;
				$requirement->save();
				$arr['rscode']=0;
				return $arr;
				} catch(\Exception $e) {
					Yii::error("Requirement::DelRequirementByRequirementid error is ".$e->getMessage()."\n");
					$arr['rscode']=1;
					$arr['error']=$e->getMessage();
	           	 	return $arr;
       	 	}
		}


		public static function GetUserLimit($jsonObj){
			try{
					$user_require = static::find()->where(['publishuserid'=>$jsonObj->userid, 'validflag'=>1])->orderBy('id')->asArray()->all();
					$user_require_count = count($user_require);
					Yii::error("user_require is ".print_r($user_require,1)."\n");
					$arr['rscode']=0;
		            $arr['user_require_count']=$user_require_count;
		            return $arr;
				} catch(\Exception $e) {
					Yii::error("Requirement::GetUserLimit error is ".$e->getMessage()."\n");
					$arr['rscode']=1;
		            $arr['error']=$e->getMessage();
		            return $arr;
		        }
		}


		public static function UpdateRequirementTime($jsonObj){
				$require = static::find()->where(['id'=>$jsonObj->requirementid, 'validflag'=>1])->one();
				Yii::trace("require is ".print_r($require,1)."\n");
				$require->updatetime=date('y-m-d H:i:s',time());
				$require->save();
				$arr['rscode']=0;
		    	$arr['id']=$jsonObj->requirementid;
		    	return $arr;
		}

		public function getRecommendRequirement($data){
			$suppy = new \frontend\models\Supplyment();
			$houseinfo = $suppy::findOne($data);
			$ResidentialInfo = \frontend\models\ResidentialInfo::find()->where(['districtid'=>$houseinfo->districtid])->one();
			$region = "13".$ResidentialInfo['region']."00";
			// var_dump($region);
			$where .= " AND FIND_IN_SET(".$region.",t_requirement.regions)";
			$result = Yii::$app->db->createCommand('SELECT `t_requirement`.*, `t_user`.`nickname`, `t_user`.`picture`, `t_user`.`agentflag` FROM `t_requirement` LEFT JOIN `t_user` ON t_user.id = t_requirement.publishuserid WHERE ((`t_requirement`.`validflag`= 1) AND (`t_user`.`validflag`=1))'.$where.' order by t_requirement.updatetime desc limit 24')
		           ->queryAll();
		    
			foreach ($result as $i => $value) {
				// var_dump($value['districtid']);
				$res[$i] = $value;
				$res[$i]['mark'] = $suppy->getMark($value,$houseinfo->attributes);
			}
			$cnt = count($res);
			    for ($i = 0; $i < $cnt; $i++) {
			        for ($j = 0; $j < $cnt - $i - 1; $j++) {
			            if ($res[$j]['mark'] < $res[$j + 1]['mark']) {
			                $temp = $res[$j];
			                $res[$j] = $res[$j + 1];
			                $res[$j + 1] = $temp;
			            }
			        }
			    }
			return $res;
		}


		public static function PushRequirement($jsonObj){
				Yii::error("Requirement::PushRequirement jsonObj is ".print_r($jsonObj,1)."\n");
				//先根据需求id获取到需求详情，然后查找t_requirement记录里面的 region1 字段
				$require = static::find()->where(['id'=>$jsonObj->requirementid, 'validflag'=>1])->one();
				Yii::error("require is ".print_r($require,1)."\n");

				//增加不向同公司同事推送的逻辑
				//获取发布所属的公司---经纪人
				$publishAgentOrganization = null;
				$publishAgentInfo = Agent::findIdentity($require->publishuserid);
				if(!empty($publishAgentInfo) && !empty($publishAgentInfo->organization))
				{
					$publishAgentOrganization = $publishAgentInfo->organization;
				}

				$regions=null;
				$user=null;
				
				//如果有该字段，则是按照区域发布的，区域分11地铁和13板块两种
				if($require->region1|$require->region2|$require->region3){
					$f2=substr($require->region1,0,2);
					if($require->region1){
						$regions[0]=$require->region1;
					}
					if($require->region2){
						$regions[1]=$require->region2;
					}
					if($require->region3){
						$regions[2]=$require->region3;
					}
					Yii::error("f2 is $f2\n");
					//如果是13开头的，那么板块ID就是 region1,region2,region3字段的值
					if($f2=='13'){
						foreach ($regions as $region){
							$connection = Yii::$app->db;
							$sql='SELECT * FROM v_agent WHERE FIND_IN_SET('.$region.',activeregion)';
							
							//除限制区域外增加，其他限制，如不发给同公司的同事
							static::pushRequirementToUser($publishAgentOrganization,$jsonObj->requirementid,$require->publishuserid,$sql);

							/**
							$command = $connection->createCommand($sql);
                    		$users = $command->queryAll();
                    		Yii::error("Requirement::PushRequirement users are ".print_r($users,1)."\n");
                    		//发送模板消息
                    		foreach ($users as $user) {
                    			static::sendTemplateMessage($user['userid'],$require->publishuserid,$content,$jsonObj->requirementid);
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
	                    		static::pushRequirementToUser($publishAgentOrganization,$jsonObj->requirementid,$require->publishuserid,$sql);
	                    		/**

								$command = $connection->createCommand($sql);
	                    		$users = $command->queryAll();
	                    		Yii::error("Requirement::PushRequirement users are ".print_r($users,1)."\n");
	                    		//发送模板消息
	                    		foreach ($users as $user) {
	                    			static::sendTemplateMessage($user['userid'],$require->publishuserid,$content,$jsonObj->requirementid);
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
					$sql='SELECT * FROM t_residential_district WHERE districtid=$require->districtid';
					$command = $connection->createCommand($sql);
            		$residential_district = $command->queryAll();
            		$region='13'.$residential_district[0]['region'].$residential_district[0]['plate'];
            		$sql='SELECT * FROM v_agent WHERE FIND_IN_SET('.$region.',activeregion)';

					static::pushRequirementToUser($publishAgentOrganization,$jsonObj->requirementid,$require->publishuserid,$sql);
					/**
					$command = $connection->createCommand($sql);
            		$users = $command->queryAll();
            		Yii::error("Requirement::PushRequirement users are ".print_r($users,1)."\n");
            		////发送模板消息
            		foreach ($users as $user) {
            			static::sendTemplateMessage($user['userid'],$require->publishuserid,$content,$jsonObj->requirementid);
            		}
            		**/
				}
        		
        		$arr['recode']=0;
		    	return $arr;
		}


		static function pushRequirementToUser($publishAgentOrganization,$requirementid,$publishuserid,$findusersql)
		{
			$content='您的区域有新的求购需求请查看';
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



	static function sendTemplateMessage($userid,$expertid,$content,$requirementId)
    {
        //$userid是收信人，$expertid是发信人就是需求发布者，$conten是内容，$requirementId是需求ID
        $template = array();
        $template['data'] = array();

        Yii::error("sendTemplateMessage: userid is $userid, expertid is $expertid, content is $content,
            orderid is $orderid\n");

    	$userid=$userid;
    	$fromNickname='芝麻找房';
    	
        $url='http://www.zmzfang.com/weixin/HomePage/RequirementDetail.html?requirementId='.$requirementId.'&userId='.$expertid;
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

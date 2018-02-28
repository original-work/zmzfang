<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\helpers\Functions;
use common\models\Wechat;

class Appointment extends ActiveRecord
{
	public static function tableName()
    {
        return 't_expert_appointment';
    }

    public static function appointmentOffline($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_expert where id=%s", $jsonObj->expertid);
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();
                    $expert_count = count($expert);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert[0] is ".print_r($expert[0],1)."\n");

                    /* 在 t_expert_appointment 中增加一条记录 */
                    $appointment = new Appointment();
                    $appointment->userid=$jsonObj->userid;
                    $appointment->expertid=$jsonObj->expertid;
                    $appointment->appointmenttype=2;
                    $appointment->appointmentsubject=$jsonObj->appointmentsubject;
                    $appointment->fee=$expert[0][offlinecharge];
                    $appointment->ordersubject="芝麻找房商品";
                    $appointment->status=0;
                    $appointment->createtime=date('y-m-d H:i:s',time());
                    $appointment->updatetime=date('y-m-d H:i:s',time());
                    $appointment->validflag=1;
                    $appointment->paytype=1;
                    $appointment->save();

                    /* 增加一条 t_expert_appointment_status 的记录 */
                    $sql = sprintf("SELECT * FROM t_expert_appointment WHERE userid=%s AND expertid=%s AND appointmenttype=%s 
                        AND appointmentsubject='%s' AND validflag=1", $jsonObj->userid,$jsonObj->expertid,2,$jsonObj->appointmentsubject);
                    $command = $connection->createCommand($sql);
                    $appointment = $command->queryAll();
                    $appointment_count = count($appointment);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment count is ".$appointment_count."\n");
                    Yii::error("appointment[0] is ".print_r($appointment[0],1)."\n");

                    $orderid=$appointment[0][id];
                    $time=date('y-m-d H:i:s',time());
                    $sql = sprintf("INSERT INTO t_expert_appointment_status (orderid,orderstatus,statustime,operator) 
                        VALUES ($orderid, 0, '$time', $jsonObj->userid)");
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();

					//给专家发送模板消息
					$type=2;
					$content="有新的用户想约见您";
					\common\helpers\Functions::sendTemplateMessage($type,$jsonObj->userid,$jsonObj->expertid,$content,$orderid,2);
										
                    /* 返回结果 */
                    $res[orderid]=$appointment[0][id];
                    $res[ordersubject]=$appointment[0][ordersubject];
                    $res[fee]=$appointment[0][fee];
                    return $res;

            } catch(\Exception $e) {
                    Yii::error("Appointment::appointmentOffline error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }

    public static function getAppointment($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_expert_appointment WHERE userid=%s AND validflag=1 ORDER BY updatetime DESC LIMIT %s,%s",$jsonObj->userid,$jsonObj->start,$jsonObj->count);
                    $command = $connection->createCommand($sql);
                    $appointment = $command->queryAll();
                    $appointment_count = count($appointment);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment[0] is ".print_r($appointment[0],1)."\n");
                    Yii::error("appointment count is ".count($appointment)."\n");

                    for($i=0;$i<$appointment_count;$i++){
                        $res[$i]['expertid']=$appointment[$i][expertid];


                        $sql = sprintf("SELECT * FROM t_expert WHERE id=%s",$appointment[$i][expertid]);
                        $command = $connection->createCommand($sql);
                        $expert = $command->queryAll();
                        $expert_count = count($expert);

                        Yii::error("sql is ".$sql."\n");
                        Yii::error("expert[0] is ".print_r($expert[0],1)."\n");
                        Yii::error("expert count is ".count($expert)."\n");

                        $res[$i]['expertname']=$expert[0][name];
                        $res[$i]['expertpicture']=$expert[0][headpicture];
                        $res[$i]['expertorganization']=$expert[0][organization];

                        $domain = explode(",", $expert[0][domain]);
                        $domain_count = count($domain);
                        Yii::error("domain is ".print_r($domain,1)."\n");
                        Yii::error("domain count is ".count($domain)."\n");


                        for($k=0;$k<$domain_count;$k++){
                            
                            switch($domain[$k]){
                                case '1':
                                    Yii::error("domain[$k] is 1\n");
                                    $res[$i]['domain'].='政策 ';
                                    Yii::error("res[$i][domain] is ".$res[$i]['domain']."\n");
                                    break;
                                case '2':
                                    Yii::error("domain[$k] is 2\n");
                                    $res[$i]['domain'].='贷款 ';
                                    Yii::error("res[$i][domain] is ".$res[$i]['domain']."\n");
                                    break;
                                case '3':
                                    Yii::error("domain[$k] is 3\n");
                                    $res[$i]['domain'].='交易 ';
                                    Yii::error("res[$i][domain] is ".$res[$i]['domain']."\n");
                                    break;
                                case '4':
                                    Yii::error("domain[$k] is 4\n");
                                    $res[$i]['domain'].='法律 ';
                                    Yii::error("res[$i][domain] is ".$res[$i]['domain']."\n");
                                    break;
                            }
                        }

                        $res[$i]['domain']=substr($res[$i]['domain'],0,strlen($res[$i]['domain'])-1);

                        $res[$i]['appointmentorederid']=$appointment[$i][id];
                        $res[$i]['questionid']=$appointment[$i][questionid];
                        $res[$i]['appointmenttype']=$appointment[$i][appointmenttype];
                        $res[$i]['fee']=$appointment[$i][fee];
                        $res[$i]['status']=$appointment[$i][status];
                        $res[$i]['subject']=$appointment[$i][appointmentsubject];
                        $res[$i]['createtime']=$appointment[$i][createtime];
                        $res[$i]['updatetime']=$appointment[$i][updatetime];
                    }

                    return $res;
            } catch(\Exception $e) {
                    Yii::error("Appointment::getAppointment error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }

    public static function GetAppointmentStatus($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_expert_appointment_status WHERE orderid=%s",$jsonObj->orderid);
                    $command = $connection->createCommand($sql);
                    $appointment_status = $command->queryAll();
                    $appointment_status_count = count($appointment_status);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment_status[0] is ".print_r($appointment_status[0],1)."\n");
                    Yii::error("appointment_status count is ".count($appointment_status)."\n");

                    $sql = sprintf("SELECT * FROM t_user WHERE id=%s",$jsonObj->userid);
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    $user_count = count($user);
                    if(0==$user_count){
                        $res['rscode']=0;
                        return $res;
                    }

                    for($i=0;$i<$appointment_status_count;$i++){
                        $res[$i]['id']=$appointment_status[$i][id];
                        $res[$i]['orderid']=$appointment_status[$i][orderid];
                        $res[$i]['orderstatus']=$appointment_status[$i][orderstatus];
                        $res[$i]['statustime']=$appointment_status[$i][statustime];
                        $res[$i]['operator']=$appointment_status[$i][operator];
                    }
  
                    return $res;
            } catch(\Exception $e) {
                    Yii::error("Appointment::GetAppointmentStatus error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }


    public static function DeleteAppointment($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("UPDATE t_expert_appointment SET validflag=0 WHERE userid=%s AND id=%s AND validflag=1",$jsonObj->userid,$jsonObj->orderid);
                    $command = $connection->createCommand($sql);
                    $command->execute();
                    Yii::error("sql is ".$sql."\n");
                    
                    $res['rscode']=0;
                    return $res;
            } catch(\Exception $e) {
                    Yii::error("Appointment::DeleteAppointment error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }


    public static function GetAppointmentAsExpert($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_expert_appointment WHERE expertid=%s ORDER BY updatetime DESC LIMIT %s,%s",$jsonObj->expertid,$jsonObj->start,$jsonObj->count);
                    $command = $connection->createCommand($sql);
                    $appointment = $command->queryAll();
                    $appointment_count = count($appointment);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment count is ".count($appointment)."\n");

                    for($i=0;$i<$appointment_count;$i++){
                        $sql = sprintf("SELECT * FROM t_user WHERE id=%s",$appointment[$i][userid]);
                        $command = $connection->createCommand($sql);
                        $user = $command->queryAll();
                        $res[$i]['appointmentorederid']=$appointment[$i][id];
                        $res[$i]['userid']=$user[0][id];
                        $res[$i]['nickname']=$user[0][nickname];
                        $res[$i]['userpicture']=$user[0][picture];
                        $res[$i]['subject']=$appointment[$i][appointmentsubject];
                        $res[$i]['appointmenttype']=$appointment[$i][appointmenttype];
                        $res[$i]['fee']=$appointment[$i][fee];
                        $res[$i]['status']=$appointment[$i][status];
                        $res[$i]['createtime']=$appointment[$i][createtime];
                        
                        Yii::error("$res[$i] is ".print_r($appointment[$i],1)."\n");
                    }
                    
                    return $res;
            } catch(\Exception $e) {
                    Yii::error("Appointment::GetAppointmentAsExpert error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }


    public static function ModifyOrderStatus($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $time=date('Y-m-d H:i:s',time());
                    /*  更新t_expert_appointment（专家约见订单表）中指定订单id的状态  */
                    $connection = Yii::$app->db;
                    $sql = sprintf("UPDATE t_expert_appointment SET status=%s,updatetime='%s' WHERE expertid=%s AND id=%s",$jsonObj->status, $time, $jsonObj->expertid, $jsonObj->orderid);
                    $command = $connection->createCommand($sql);
                    $command->execute();
										
                    Yii::error("sql is ".$sql."\n");
                    $appointment=static::findOne($jsonObj->orderid);
                    $appointmenttype= $appointment->appointmenttype;
                    Yii::error("appointmenttype is ".$appointmenttype."\n");
                    if(!empty($appointmenttype)){
                    		if($appointmenttype==1){
                    				//线上提问
                    				if($jsonObj->status == 2 || $jsonObj->status == 3){
                    						//答复或拒绝 操作人专家
				                        $sql = sprintf("SELECT * FROM t_expert where id=%s",$jsonObj->expertid);
				                        $command = $connection->createCommand($sql);
				                        $expert = $command->queryAll();
				                        $expert_count = count($expert);
				                        $name = $expert[0][name];
                                            //专家拒绝
                                        if($jsonObj->status == 3){
                                            //用户account
                                            $account = \frontend\models\Account::find()->where(['userid'=>$appointment->userid])->one();
                                            if($account){
                                                $account->historyincome += $appointment->fee;
                                                $account->historyprofit += $appointment->fee;
                                                $account->remainedprofit += $appointment->fee;
                                                $account->updatetime = $time;
                                                $account->save();
                                            }else{
                                                $toUserInfo=User::find()->select('wxopenid,phone,wxunionid,id,nickname')->where(['id'=>$appointment->userid])->asArray()->one();
                                                $newAccount = new \frontend\models\Account();
                                                $newAccount->userid = $appointment->userid;
                                                $newAccount->usertype = 1;
                                                $newAccount->openid = $toUserInfo['wxopenid'];
                                                $newAccount->historyincome = $appointment->fee;
                                                $newAccount->historyprofit = $appointment->fee;
                                                $newAccount->drawedprofit =0;
                                                $newAccount->usedprofit = 0;
                                                $newAccount->remainedprofit = $appointment->fee;
                                                $newAccount->lockingprofit =0;
                                                $newAccount->createtime = $time;
                                                $newAccount->updatetime = $time;
                                                $newAccount->save();
                                            }

                                            

                                            $accountDetail = new \frontend\models\AccountDetail();
                                            $accountDetail->userid = $appointment->userid;
                                            $accountDetail->usertype= 1;
                                            $accountDetail->sumdate= date('Ymd',time());
                                            $accountDetail->accounttype = '10';
                                            $accountDetail->servicetype = '1004';
                                            $accountDetail->originalfee = $appointment->fee;
                                            $accountDetail->actualfee = $appointment->fee;
                                            $accountDetail->subject ='线上提问退款';
                                            $accountDetail->ordertype = 2;
                                            $accountDetail->orderid = $jsonObj->orderid;
                                            $accountDetail->createtime = $time;
                                            $accountDetail->save();
                                        }
				                    }
				                    else if($jsonObj->status == 0 || $jsonObj->status == 1){
				                    	  //新建支付 操作人 用户
				                        $sql = sprintf("SELECT t_user.nickname FROM t_expert_appointment LEFT JOIN t_user ON 
				                            t_expert_appointment.userid=t_user.id WHERE t_expert_appointment.id=%s AND 
				                            t_expert_appointment.validflag=1",$jsonObj->orderid);
				                        $command = $connection->createCommand($sql);
				                        $expert = $command->queryAll();
				                        $expert_count = count($expert);
				                        $name = $expert[0]['nickname'];
				                    }
				                    else if($jsonObj->status == 4){
				                    		$name = 'system';
				                    }
                    		}
                    		else if($appointmenttype==2)
                    		{
                    				//线下约见
                    				if($jsonObj->status == 1 || $jsonObj->status == 3 ||$jsonObj->status == 7){
                    						//接收确认1 确认流程结束3 拒绝7 操作人专家
				                        $sql = sprintf("SELECT * FROM t_expert where id=%s",$jsonObj->expertid);
				                        $command = $connection->createCommand($sql);
				                        $expert = $command->queryAll();
				                        $expert_count = count($expert);
				                        $name = $expert[0][name];
				                    }else if($jsonObj->status == 0 || $jsonObj->status == 2 ||$jsonObj->status == 4){
				                    	  //新建 支付 确认流程结束 操作人 用户
				                        $sql = sprintf("SELECT t_user.nickname FROM t_expert_appointment LEFT JOIN t_user ON 
				                            t_expert_appointment.userid=t_user.id WHERE t_expert_appointment.id=%s AND 
				                            t_expert_appointment.validflag=1",$jsonObj->orderid);
				                        $command = $connection->createCommand($sql);
				                        $expert = $command->queryAll();
				                        $expert_count = count($expert);
				                        $name = $expert[0]['nickname'];
				                    }
				                    else
				                    {
				                    		$name = 'system';
				                    }
                    		}
                    		else
                    		{
                    		    Yii::error("no appointmenttype $appointmenttype found\n");
		                        $res['rscode']=1;
		                        $res['no appointmenttype found'];
		                        return $res;
                    		}
                    }
                    else
                    {
                    	  Yii::error("no appointmenttype $appointmenttype found\n");
                        $res['rscode']=1;
                        $res['no appointmenttype found'];
                        return $res;
                    }                    

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert[0] is ".print_r($expert[0],1)."\n");
                    Yii::error("expert count is ".count($expert)."\n");

                    /*  在t_expert_appointment_status（专家约见订单状态表）中增加一条状态信息  */
                    $statustime=date('y-m-d H:i:s',time());
                    $sql = sprintf("INSERT INTO t_expert_appointment_status (orderid,orderstatus,statustime,operator) 
                        VALUES (%s, %s, '%s', '%s')", $jsonObj->orderid, $jsonObj->status, $statustime,$name);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    $userid=$jsonObj->userid;
                    $expertid=$jsonObj->expertid;
                    $orderid=$jsonObj->orderid;
                    if($appointmenttype==1){//线上约见
                        switch($jsonObj->status){
                            case 1:
                                $content='客户已经支付';
                                $type=2;//向expert发送消息
                                break;
                            case 2:
                                $content='专家已经答复';
                                $type=1;//向user发送消息
                                break;
                            case 3:
                                $content='专家拒绝答复';
                                $type=1;//向user发送消息
                                break;
                            case 4:
                                $content='专家超时未答复';
                                $type=1;//向user发送消息
                                break;
                            default:
                                break;
                        }
                    }elseif($appointmenttype==2){//线下约见
                        switch($jsonObj->status){
                        	 case 0:
                                $content='客户发起约见';
                                $type=2;//向expert发送消息
                                break;
                            case 2:
                                $content='客户已经支付';
                                $type=2;//向expert发送消息
                                break;
                            case 4:
                                $content='客户确认流程结束';
                                $type=2;//向expert发送消息
                                break;
                            case 5:
                                $content='平台已经打款给您，请查收';
                                $type=2;//向expert发送消息
                                break;
                            case 1:
                                $content='专家确认，等待客户支付';
                                $type=1;//向user发送消息
                                break;
                            case 3:
                                $content='专家确认流程结束';
                                $type=1;//向user发送消息
                                break;
                            case 7:
                                $content='专家拒绝';
                                $type=1;//向user发送消息
                                break;
                            case 8:
                                $content='专家超时未处理';
                                $type=1;//向user发送消息
                                break;
                            case 9:
                                $content='其它原因退款';
                                $type=1;//向user发送消息
                                break;
                            default:
                                break;
                        }
                    }
                   
                    Yii::error("type is $type, userid is $userid, expertid is $expertid, content is $content\n");
                    \common\helpers\Functions::sendTemplateMessage($type,$userid,$expertid,$content,$orderid,$appointmenttype);
                    $res['rscode']=0;
                    return $res;
            } catch(\Exception $e) {
                    Yii::error("Appointment::ModifyOrderStatus error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }



    public static function TestTemplateMessage($jsonObj)
    {
            Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
            // $model = new \common\helpers\Functions();
            $res=\common\helpers\Functions::sendTemplateMessage($jsonObj->type,$jsonObj->userid,$jsonObj->expertid,
                $jsonObj->content,$jsonObj->orderid,$jsonObj->appointmenttype);
            // $res=$model->sendTemplateMessage($jsonObj->type,$jsonObj->userid,$jsonObj->expertid,$jsonObj->content);
            return $res;
    }


    public static function getAppointmentDetail($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_expert_appointment WHERE id=%s",$jsonObj->orderid);
                    $command = $connection->createCommand($sql);
                    $appointment = $command->queryAll();
                    $appointment_count = count($appointment);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment[0] is ".print_r($appointment[0],1)."\n");
                    Yii::error("appointment count is ".count($appointment)."\n");

                    if(0==$appointment_count){
                        $res['rscode']=1;
                        $res['reason']="no such orderid";
                    }

                    $res['expertid']=$appointment[0][expertid];

                    $sql = sprintf("SELECT * FROM t_expert WHERE id=%s",$appointment[0][expertid]);
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();
                    $expert_count = count($expert);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert[0] is ".print_r($expert[0],1)."\n");
                    Yii::error("expert count is ".count($expert)."\n");

                    $res['expertname']=$expert[0][name];
                    $res['expertpicture']=$expert[0][headpicture];
                    $res['expertorganization']=$expert[0][organization];

                    $domain = explode(",", $expert[0][domain]);
                    $domain_count = count($domain);
                    Yii::error("domain is ".print_r($domain,1)."\n");
                    Yii::error("domain count is ".count($domain)."\n");


                    for($k=0;$k<$domain_count;$k++){
                        
                        switch($domain[$k]){
                            case '1':
                                Yii::error("domain[$k] is 1\n");
                                $res['domain'].='政策 ';
                                Yii::error("res[domain] is ".$res['domain']."\n");
                                break;
                            case '2':
                                Yii::error("domain[$k] is 2\n");
                                $res['domain'].='贷款 ';
                                Yii::error("res[domain] is ".$res['domain']."\n");
                                break;
                            case '3':
                                Yii::error("domain[$k] is 3\n");
                                $res['domain'].='交易 ';
                                Yii::error("res[domain] is ".$res['domain']."\n");
                                break;
                            case '4':
                                Yii::error("domain[$k] is 4\n");
                                $res['domain'].='法律 ';
                                Yii::error("res[domain] is ".$res['domain']."\n");
                                break;
                        }
                    }

                    $res['domain']=substr($res['domain'],0,strlen($res['domain'])-1);
                    $res['appointmentorederid']=$appointment[0][id];
                    $res['questionid']=$appointment[0][questionid];
                    $res['appointmenttype']=$appointment[0][appointmenttype];
                    $res['fee']=$appointment[0][fee];
                    $res['status']=$appointment[0][status];
                    $res['subject']=$appointment[0][appointmentsubject];
                    $res['createtime']=$appointment[0][createtime];
                    $res['updatetime']=$appointment[0][updatetime];


                    $sql = sprintf("SELECT * FROM t_user WHERE id=%s",$appointment[0][userid]);
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    $user_count = count($user);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("user[0] is ".print_r($user[0],1)."\n");
                    Yii::error("user count is ".count($user)."\n");

                    $res['userid']=$appointment[0][userid];
                    $res['nickname']=$user[0][nickname];
                    $res['userpicture']=$user[0][picture];

                    return $res;

                }catch(\Exception $e) {
                    Yii::error("Appointment::getAppointment error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
                }
    }


    public static function AppointmentNotify()
    {
        echo "Appointment::AppointmentNotify\n";
        $appointments = static::find()->where(['status' => 1, 'validflag' => 1])->orderBy('id')->asArray()->all();
        echo "appointments are : ".print_r($appointments,1)."\n";

        foreach ($appointments as $appointment) {
            $time1 = date('Y-m-d H:i:s',time());
            $time2 = $appointment['updatetime'];
            $gap = strtotime($time1)-strtotime($time2);
            $hours = round($gap/60/60);
            if($hours>24){
                echo "appointment is : ".print_r($appointment,1)."\n";
                $content='您有付费问题超过一天没有回答';
                static::sendTemplateMessage($appointment['expertid'],$appointment['id'],$content);
            }
        }
    }


    static function sendTemplateMessage($expertid,$orderId,$content)
    {
        //$userid是收信人，$orderId是t_expert_appointment表的id，$conten是内容
        $template = array();
        $template['data'] = array();

        echo "sendTemplateMessage: expertid is $expertid, orderId is $orderId, content is $content\n";

        $userid=Expert::findOne($expertid)->userid;

        $fromNickname='芝麻找房';
        
        $url='http://www.zmzfang.com/weixin/Expert/Mine/AppointmentMeDetail.html?orderId='.$orderId;
        echo "case 1: userid is $userid, fromNickname is $fromNickname, url is $url\n";

        $toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
        echo "toUserInfo is : ".print_r($toUserInfo,1)."\n";

        $content = isset($content)?$content:"点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的消息请查收';
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,$fromNickname,date('Y-m-d H:i:s',time()),$content];
        $col = [];

        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['wxopenid'];
        $template['url']    = $url;
        echo "template is : ".print_r($template,1)."\n";
        
        if(!empty($toUserInfo['wxopenid'])){
            $Wechatmodel = new Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
        }else{
            $res =[];
        }
        
        return $res;
    }


}

?>
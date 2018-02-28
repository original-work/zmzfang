<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Answer extends ActiveRecord
{
	public static function tableName()
    {
        return 't_question_answer';
    }

    public static function getAnswer($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_question_answer WHERE expertid=%s  and answer is not null order by priority desc,anserdate desc LIMIT %s,%s", $jsonObj->expertid, $jsonObj->start, $jsonObj->count);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer count is ".count($answer)."\n");

                    for($i=0;$i<$answer_count;$i++){
                        $arr[$i][id]=$answer[$i][id];
                        $arr[$i][userid]=$answer[$i][userid];
                        $arr[$i][questionsubject]=$answer[$i][questionsubject];
                        $arr[$i][questiondetail]=$answer[$i][questiondetail];
                        $arr[$i][expertid]=$answer[$i][expertid];
                        $arr[$i][answer]=$answer[$i][answer];
                        $arr[$i][listenedcnt]=$answer[$i][listenedcnt];
                        $arr[$i][questiondate]=$answer[$i][questiondate];
                        $arr[$i][anserdate]=$answer[$i][anserdate];

                        $sql = sprintf("SELECT * FROM t_user WHERE id=%s", $arr[$i][userid]);
                        $command = $connection->createCommand($sql);
                        $user = $command->queryAll();
                        Yii::error("sql is ".$sql."\n");
                        $arr[$i][nickname]=$user[0][nickname];
                        $arr[$i][picture]=$user[0][picture];
                        Yii::error("arr[".$i."] is ".print_r($arr[$i],1)."\n");
                    }               
                    
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Answer::getAnswer error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }

/*
    public static function getAnswerList($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $connection = Yii::$app->db;
                    $sql = sprintf("select * from t_question_answer t where listenedcnt=(select max(listenedcnt)from t_question_answer where id=t.id) and answer is not null order by anserdate desc limit %s,%s", $jsonObj->start, $jsonObj->count);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer count is ".count($answer)."\n");

                    for($i=0;$i<$answer_count;$i++){
                        $arr[$i][id]=$answer[$i][id];
                        $arr[$i][userid]=$answer[$i][userid];
                        $arr[$i][questionsubject]=$answer[$i][questionsubject];
                        $arr[$i][questiondetail]=$answer[$i][questiondetail];
                        $arr[$i][expertid]=$answer[$i][expertid];
                        $arr[$i][answer]=$answer[$i][answer];
                        $arr[$i][listenedcnt]=$answer[$i][listenedcnt];
                        $arr[$i][questiondate]=$answer[$i][questiondate];
                        $arr[$i][anserdate]=$answer[$i][anserdate];

                        $sql = sprintf("SELECT * FROM t_user WHERE id=%s", $arr[$i][userid]);
                        $command = $connection->createCommand($sql);
                        $user = $command->queryAll();
                        Yii::error("sql is ".$sql."\n");
                        $arr[$i][username]=$user[0][nickname];
                        $arr[$i][userpicture]=$user[0][picture];


                        $sql = sprintf("SELECT * FROM t_expert WHERE id=%s", $arr[$i][expertid]);
                        $command = $connection->createCommand($sql);
                        $expert = $command->queryAll();
                        Yii::error("sql is ".$sql."\n");
                        $arr[$i][expertname]=$expert[0][name];
                        $arr[$i][expertpicture]=$expert[0][headpicture];


                        Yii::error("arr[".$i."] is ".print_r($arr[$i],1)."\n");
                    }                  
                    
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Answer::getAnswer error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }
    */

    public static function getAnswerList($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $connection = Yii::$app->db;
                    $sql = sprintf("select *,TIMESTAMPDIFF(SECOND,  anserdate,now()) as anserinterval from v_question_answer t where answer is not null order by priority desc,anserdate desc limit %s,%s", $jsonObj->start, $jsonObj->count);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer count is ".count($answer)."\n");

                    for($i=0;$i<$answer_count;$i++){
                        $arr[$i][id]=$answer[$i][id];
                        $arr[$i][userid]=$answer[$i][userid];
                        $arr[$i][questionsubject]=$answer[$i][questionsubject];
                        $arr[$i][questiondetail]=$answer[$i][questiondetail];
                        $arr[$i][expertid]=$answer[$i][expertid];
                        $arr[$i][answer]=$answer[$i][answer];
                        $arr[$i][listenedcnt]=$answer[$i][listenedcnt];
                        $arr[$i][questiondate]=$answer[$i][questiondate];
                        $arr[$i][anserdate]=$answer[$i][anserdate];

                        $arr[$i][username]=$answer[$i][usernickname];
                        $arr[$i][userpicture]=$answer[$i][userpicture];


                        $arr[$i][expertid]=$answer[$i][expertid];
                        $arr[$i][expertname]=$answer[$i][expertname];
                        $arr[$i][expertpicture]=$answer[$i][expertpicture];
                        $arr[$i][anserinterval]=$answer[$i][anserinterval];

                        //$arr[$i]['listenpermission'] = 0;
                        $arr[$i]['listenpermission'] = 1;
                        if($arr[$i]['userid'] == $jsonObj->userid || $arr[$i]['expertid'] == $jsonObj->expertid){
                            $arr[$i]['listenpermission'] = 1;
                        }
                        if(\frontend\models\PayQuestion::findOne(['questionid'=>$arr[$i]['id'],'userid'=>$jsonObj->userid,
                            'status'=>1])){
                            $arr[$i]['listenpermission'] = 1;
                        }
                        if($arr[$i]['anserinterval'] < 3600)
                        {
                            //回答后1小时免费
                            $arr[$i]['listenpermission'] = 1;
                        }


                        Yii::error("arr[".$i."] is ".print_r($arr[$i],1)."\n");
                    }                  
                    
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Answer::getAnswer error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }


    public static function modifyListenCnt($jsonObj)
    {
            try{
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_question_answer where id=%s",$jsonObj->questionid);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer[0] is ".print_r($answer[0],1)."\n");
                    Yii::error("answer count is ".count($answer)."\n");
                    Yii::error("old listenedcnt is ".$listenedcnt."\n");
                    $listenedcnt = $answer[0][listenedcnt]+1;
                    Yii::error("new listenedcnt is ".$listenedcnt."\n");

                    $sql = sprintf("UPDATE t_question_answer set listenedcnt=%s where id=%s", $listenedcnt, $jsonObj->questionid);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    $arr['rscode']=0;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("PayQuestion::modifyListenCnt error is ".$e->getMessage()."\n");
                    $arr['rscode']=1;
                    return $arr;
            }
    }

    public static function askQuestionOnline($jsonObj)
    {
            try{
                    /* 在 t_question_answer（问题答复表）中增加一条记录 */
                    $answer = new Answer();
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $answer->userid=$jsonObj->userid;
                    $answer->questionsubject=$jsonObj->questionsubject;
                    $answer->questiondetail=$jsonObj->questiondetail;
                    $answer->expertid=$jsonObj->expertid;
                    $answer->questiondate=date('y-m-d H:i:s',time());
                    $answer->save();


                    /* 在 t_expert_appointment 中增加一条记录 */
                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * FROM t_question_answer where userid=%s and expertid=%s and questionsubject='%s' and questiondetail='%s'", $jsonObj->userid, $jsonObj->expertid, $jsonObj->questionsubject, $jsonObj->questiondetail);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer[0] is ".print_r($answer[0],1)."\n");
                    Yii::error("answer count is ".count($answer)."\n");


                    $sql = sprintf("SELECT * FROM t_expert where id=%s", $answer[0][expertid]);
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();
                    $expert_count = count($expert);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert[0] is ".print_r($expert[0],1)."\n");
                    Yii::error("expert count is ".count($expert)."\n");

     
                    $userid=$jsonObj->userid;
                    $expertid=$answer[0][expertid];
                    $questionid=$answer[0][id];
                    $time=date('y-m-d H:i:s',time());
                    
                    $ordersubject='芝麻找房商品';
                    $fee=$expert[0][onlinecharge];

                    $sql = sprintf("INSERT INTO t_expert_appointment (userid,expertid,appointmenttype,questionid,appointmentsubject,fee,ordersubject,status,createtime,updatetime,validflag,paytype) 
                        VALUES (%s, %s, 1, %s, '%s', %s, '%s', 0, '%s', '%s', 1, 1)", $userid,$expertid,$questionid,
                        $jsonObj->questionsubject,$fee,$ordersubject,$time,$time);

                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();


                    /* 增加一条 t_expert_appointment_status 的记录 */
                    $sql = sprintf("SELECT * FROM t_expert_appointment WHERE userid=%s AND expertid=%s AND appointmenttype=%s 
                        AND appointmentsubject='%s' AND validflag=1", $jsonObj->userid,$jsonObj->expertid,1,$jsonObj->questionsubject);
                    $command = $connection->createCommand($sql);
                    $appointment = $command->queryAll();
                    $appointment_count = count($appointment);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("appointment count is ".$appointment_count."\n");
                    Yii::error("appointment[0] is ".print_r($appointment[0],1)."\n");
                    $id=$appointment[0][id];


                    $sql = sprintf("SELECT * FROM t_user WHERE id=%s", $jsonObj->userid);
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    $user_count = count($user);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("user count is ".$user_count."\n");
                    Yii::error("user[0] is ".print_r($user[0],1)."\n");
                    $operator=$user[0][nickname];


                    $time=date('y-m-d H:i:s',time());
                    $sql = sprintf("INSERT INTO t_expert_appointment_status (orderid,orderstatus,statustime,operator) 
                        VALUES (%s, 0, '%s', '%s')",$id,$time,$operator);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();


                    $arr['questionid']=$questionid;
                    $arr['orderid']=$id;
                    $arr['ordersubject']=$ordersubject;
                    $arr['fee']=$fee;

                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("PayQuestion::askQuestionOnline error is ".$e->getMessage()."\n");
                    $arr['rscode']=1;
                    return $arr;
            }
    }


    public static function getQuestionById($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    $connection = Yii::$app->db;
                    $sql = sprintf("SELECT * ,TIMESTAMPDIFF(SECOND,  anserdate,now()) as anserinterval FROM v_question_answer where id=%s", $jsonObj->questionid);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    Yii::error("sql is ".$sql."\n");
                    //$answer[0]['listenpermission'] = 0;
                    $answer[0]['listenpermission'] = 1;
                    if($answer[0]['userid'] == $jsonObj->userid || $answer[0]['expertuserid'] == $jsonObj->userid){
                        $answer[0]['listenpermission'] = 1;
                        return $answer[0];
                    }
                    if(\frontend\models\PayQuestion::findOne(['questionid'=>$answer[0]['id'],'userid'=>$jsonObj->userid,
                        'status'=>1])){
                        $answer[0]['listenpermission'] = 1;
                        return $answer[0];
                    }
                    if($answer[0]['anserinterval'] < 3600)
                    {
                        //回答后1小时免费
                        $answer[0]['listenpermission'] = 1;
                        return $answer[0];
                    }
                    return $answer[0];
            } catch(\Exception $e) {
                    Yii::error("Answer::getQuestionById error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }

    public static function UpdateQuestionAnswer($jsonObj)
    {
            try{
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

                    /* 首先上传文件 代码参考  http://www.w3school.com.cn/php/php_file_upload.asp */
                    if($_FILES["$jsonObj->answerfile"]["error"] > 0)
                    {
                        Yii::error("Return Code: ".$_FILES["$jsonObj->answerfile"]["error"]."<br />");
                    }
                    else
                    {
                        Yii::error("Upload: ".$_FILES["$jsonObj->answerfile"]["name"]."<br />");
                        Yii::error("Type: ".$_FILES["$jsonObj->answerfile"]["type"]."<br />");
                        Yii::error("Size: ".($_FILES["$jsonObj->answerfile"]["size"] / 1024)." Kb<br />");
                        Yii::error("Temp $jsonObj->answerfile: ".$_FILES["$jsonObj->answerfile"]["tmp_name"]."<br />)");

                        if(file_exists("/path/to/zmzfang/frontend/web/audio/".$_FILES["$jsonObj->answerfile"]["name"]))
                        {
                            Yii::error($_FILES["$jsonObj->answerfile"]["name"]." already exists. ");
                        }
                        else
                        {
                            move_uploaded_file($_FILES["$jsonObj->answerfile"]["tmp_name"],
                            "/path/to/zmzfang/frontend/web/audio/".$_FILES["$jsonObj->answerfile"]["name"]);
                            Yii::error("Stored in: "."/path/to/zmzfang/frontend/web/audio/".$_FILES["$jsonObj->answerfile"]["name"]);
                        }
                    }
                

                    /* 然后更新语音文件名到 t_question_anser 表的 answer 字段 */
                    $connection = Yii::$app->db;
                    $sql = sprintf("UPDATE t_question_answer SET answer=%s", $jsonObj->answerfile);
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    $arr['rscode']=0;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("Answer::UpdateQuestionAnswer error is ".$e->getMessage()."\n");
                    $res['rscode']=1;
                    return $res;
            }
    }

}

?>
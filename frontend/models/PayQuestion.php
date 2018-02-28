<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class PayQuestion extends ActiveRecord
{
	public static function tableName()
    {
        return 't_pay_question';
    }


    public static function listenAnswer($jsonObj)
    {
            try{
                    $connection = Yii::$app->db;
                    $question = PayQuestion::find()->where(['userid'=>$jsonObj->userid,'questionexpertid'=>$jsonObj->questionexpertid,'questionid'=>$jsonObj->questionid])->asArray()->one();
                    // var_dump($question);
                    if($question){
                        if($question['status'] == 1){
                            return ['rscode'=>0];
                        }else{
                            // Yii::error("\$question is ".print_r($question."\n"));
                            $res = ['rscode'=>1,'orderid'=>$question['orderid'],'ordersubject'=>$question['ordersubject'],'fee'=>$question['fee']];
                            // var_dump($res);
                            return $res;
                            // return ['rscode'=>1,'orderid'=>1111,'fee'=>2222];

                        }
                    }
                    $question =null;
                    // Yii::error("sql is ".$sql."\n");
                    $answerModel = \frontend\models\Answer::find()->where(['userid'=>$jsonObj->questionuserid,'expertid'=>$jsonObj->questionexpertid,'id'=>$jsonObj->questionid])->one();
                    //$answerModel->listenedcnt = $answerModel->listenedcnt +1;
                    //$answerModel->save();

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("answer[0] is ".print_r($answerModel,1)."\n");
                    Yii::error("answer count is ".count($answerModel)."\n");


                    $sql = sprintf("SELECT * FROM t_expert WHERE id=%s", $jsonObj->questionexpertid);
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();
                    $expert_count = count($expert);

                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert[0] is ".print_r($expert[0],1)."\n");
                    Yii::error("expert count is ".count($expert)."\n");


                    $model = new PayQuestion();
                    Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                    $time=date('y-m-d H:i:s',time());
                    // $num = rand();
                    $model->orderid=time();
                    $model->userid=$jsonObj->userid;
                    $model->questionuserid=$answerModel[userid];
                    $model->questionexpertid=$answerModel[expertid];
                    $model->questionid=$answerModel[id];
                    $model->status=0;
                    $model->date=$time;
                    $model->ordersubject=$answerModel[questionsubject];
                    //$model->fee=$expert[0][onlinecharge];
                    $model->fee=1;
                    $model->save();
                    $model->orderid = "ST".str_pad($model->attributes['id'],8,"0",STR_PAD_LEFT);
                    $model->save();

                    $arr['orderid']=$model->attributes['orderid'];
                    $arr['ordersubject']=$model->ordersubject;
                    $arr['fee']=$model->fee;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("PayQuestion::listenAnswer error is ".$e->getMessage()."\n");
                    var_dump($e->getMessage());
                    $arr['rscode']=1;
                    return $arr;
            }
    }


    public static function modifyPayQuestionOrderStatus($jsonObj)
    {
            try{
                    $connection = Yii::$app->db;
                    $sql = sprintf("UPDATE t_pay_question SET status=%s WHERE userid=%s AND orderid='%s'", $jsonObj->status, $jsonObj->userid, $jsonObj->orderid);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    $arr['rscode']=0;
                    return $arr;
            } catch(\Exception $e) {
                    Yii::error("PayQuestion::modifyPayQuestionOrderStatus error is ".$e->getMessage()."\n");
                    $arr['rscode']=1;
                    return $arr;
            }
    }


    public static function GetPayQuestion($jsonObj)
    {
        try{
                Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
                $connection = Yii::$app->db;
                $sql = sprintf("SELECT * FROM t_pay_question WHERE userid=%s and status=1 ORDER BY date DESC LIMIT %s,%s",$jsonObj->userid,$jsonObj->start,$jsonObj->count);
                $command = $connection->createCommand($sql);
                $pay_question = $command->queryAll();
                $pay_question_count = count($pay_question);
                Yii::error("sql is ".$sql."\n");
                Yii::error("pay_question count is ".count($pay_question)."\n");

                for($i=0;$i<$pay_question_count;$i++){
                    $arr[$i]['orderid']=$pay_question[$i][orderid];
                    $arr[$i]['userid']=$pay_question[$i][userid];
                    $arr[$i]['questionuserid']=$pay_question[$i][questionuserid];
                    $arr[$i]['questionexpertid']=$pay_question[$i][questionexpertid];

                    $sql = sprintf("SELECT * FROM t_user WHERE id=%s", $pay_question[$i][questionuserid]);
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    $user_count = count($user);
                    Yii::error("sql is ".$sql."\n");
                    Yii::error("user count is ".count($user)."\n");

                    $arr[$i]['questionusernickname']=$user[0][nickname];
                    $arr[$i]['questionuserpicture']=$user[0][picture];


                    $sql = sprintf("SELECT * FROM t_expert WHERE id=%s", $pay_question[$i][questionexpertid]);
                    $command = $connection->createCommand($sql);
                    $expert = $command->queryAll();
                    $expert_count = count($expert);
                    Yii::error("sql is ".$sql."\n");
                    Yii::error("expert count is ".count($expert)."\n");

                    $arr[$i]['expertname']=$expert[0][name];
                    $arr[$i]['expertpicture']=$expert[0][headpicture];


                    $sql = sprintf("SELECT * FROM t_question_answer WHERE id=%s", $pay_question[$i][questionid]);
                    $command = $connection->createCommand($sql);
                    $answer = $command->queryAll();
                    $answer_count = count($answer);
                    Yii::error("sql is ".$sql."\n");

                    $arr[$i]['questionsubject']=$answer[0][questionsubject];
                    $arr[$i]['questiondetail']=$answer[0][questiondetail];
                    $arr[$i]['answer']=$answer[0][answer];
                    $arr[$i]['listenedcnt']=$answer[0][listenedcnt];
                    $arr[$i]['createdate']=$answer[0][questiondate];
                }

                return $arr;
        } catch(\Exception $e) {
                Yii::error("PayQuestion::GetPayQuestion error is ".$e->getMessage()."\n");

                $arr['rscode']=1;
                return $arr;
        }
    }

}

?>
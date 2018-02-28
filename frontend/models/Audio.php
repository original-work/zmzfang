<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;
use frontend\models\Appointment;
use frontend\models\ExpertAppointment;

class Audio extends ActiveRecord
{
	public static function tableName()
    {
        return 't_audio';
    }

    public static function getAudio($serverid)
    {
        return static::findAll(['serverid'=>$serverid]);
    }

    public static function audiofromURL($url,$directory,$oldname)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close($ch);
        //$directory为存储目录
        $fp = fopen("$directory"."$oldname",'w');
        fwrite($fp, $rawdata);
        fclose($fp);
    }

    public static function convertAudio($oldname,$newname)
    {
        try{
            Yii::error("oldname is $oldname\n");
            Yii::error("newname is $newname\n");

            $php_user=shell_exec("id -a"); 
            Yii::error("php_user is $php_user\n");

            $command = "sudo -u root; export LD_LIBRARY_PATH=/usr/local/lib; /usr/local/bin/ffmpeg -i /path/to/zmzfang/frontend/web/audio/$oldname -ar 44100 -ab 128k /path/to/zmzfang/frontend/web/audio/$newname";
            Yii::error("command is: ".$command."\n");
            $result=exec($command, $output, $var); 
            if($var == 0)  
            {  
                Yii::error("transfer success\n");
            }  
            else  
            {  
                Yii::error("transfer fail\n");
                Yii::error("output is ".print_r($output)."\n");
                Yii::error("var is ".print_r($var)."\n");
                Yii::error("result is ".print_r($result)."\n");
            }
        }
        catch(\Exception $e) {
            Yii::error("Audio::convertAudio error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            $arr['error']=$e->getMessage();
            return $arr;
        }
    }


    public static function AddAudio($jsonObj)
    {
        try{
                Yii::error("AddAudio:jsonObj is ".print_r($jsonObj,1)."\n");
            //1.插入数据
                $reqlist=Audio::getAudio($jsonObj->serverid);
                if(!empty($reqlist)){
                        Yii::error("Audio already exists\n");
                        $arr['rscode']=1;
                        $arr['error']='Audio already exists';
                        return $arr;
                }
                $req = new Audio();
                $req->questionid=$jsonObj->questionid;
                $req->userid=$jsonObj->expertid;
                $req->serverid=$jsonObj->serverid;
                $req->localid=$jsonObj->localid;
                $req->status=$jsonObj->status;
                $req->updatetime=date('Y-m-d H:i:s',time());
                $req->createtime=date('Y-m-d H:i:s',time());
                $req->save();
                
            //2.根据serverid获取音频文件并保存到本地服务器
                $token=\common\models\Wechat::getWxAccessToken();

                $get_url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$token}&media_id={$jsonObj->serverid}";
                Yii::error("get_url is ".$get_url."\n");
                $time=time();
                $num = rand();
                $oldname = $time.$num.".amr";
                $newname = $time.$num.".mp3";

                $directory = "/path/to/zmzfang/frontend/web/audio/";
                $fullname = "http://www.zmzfang.com/audio/".$oldname;
            
                Audio::audiofromURL($get_url,$directory,$oldname);
                Audio::convertAudio($oldname,$newname);

        //3.更新 t_question_answer 表的 answer 字段为音频mp3文件url
                $mp3_url="http://www.zmzfang.com/audio/".$newname;
                $location=$directory.$newname;
                $model = new \common\helpers\getid3\getid3();
                $ThisFileInfo=$model->analyze($location);
                // Yii::error("ThisFileInfo is ".print_r($ThisFileInfo,1)."\n");
                $anserdate = date('Y-m-d H:i:s',time());
                $sql = sprintf("UPDATE t_question_answer SET answer=%s, duration=%s,anserdate=%s WHERE id=%s", "\"".$mp3_url."\"", 
                    (int)$ThisFileInfo['playtime_seconds'], "\"".$anserdate."\"",$jsonObj->questionid);
                $connection = Yii::$app->db;
                // Yii::error("mp3_url is ".$mp3_url."\n");
                // Yii::error("sql is ".$sql."\n");
                $command = $connection->createCommand($sql);
                $houseid = $command->execute();

        //4.执行一遍 modify-order-status 接口做的事情
                $jsonObj->status=2;
                Appointment::ModifyOrderStatus($jsonObj);

        /*5.根据 orderid 到 t_expert_appointment 表里面查找 fee,
        更新 t_account ,
        t_account.historyincome=t_account.historyincome+fee
        t_account.historyprofit=t_account.historyprofit+fee*0.9
        t_account.remainedprofit=t_account.remainedprofit+fee*0.9
        然后在 t_account_detail 创建一条记录
        */ 
                $expertAppointment=ExpertAppointment::find()->where(['id'=>$jsonObj->orderid,'validflag'=>1])->one();
                if(empty($expertAppointment)){
                        Yii::error("expertAppointment not found\n");
                        $arr['rscode']=1;
                        $arr['error']='expertAppointment not found';
                        return $arr;
                }
                $fee=$expertAppointment->fee;
                Yii::error("fee is $fee\n");

                $account=Account::find()->where(['userid'=>$jsonObj->expertid,'usertype'=>2])->one();
                Yii::error("account is ".print_r($account,1)."\n");
                if(empty($account)){
                    Yii::error("account not exist\n");
                    $account=new Account();
                    $account->userid=$jsonObj->expertid;
                    $account->usertype=2;
                    $userid=$fromNickname=Expert::findOne($jsonObj->expertid)->userid;
                    $wxopenid=User::findOne($userid)->wxopenid;
                    $account->openid=$wxopenid;
                    $account->createtime=date('Y-m-d H:i:s',time());                 
                }
                $account->historyincome=$account->historyincome+$fee;
                $account->historyprofit=$account->historyprofit+$fee*0.9;
                $account->remainedprofit=$account->remainedprofit+$fee*0.9;
                $account->updatetime=date('Y-m-d H:i:s',time());
                $account->save();


                $account_detail=new AccountDetail();
                $account_detail->userid=$jsonObj->expertid;
                $account_detail->usertype=2;
                $account_detail->sumdate=date('Y-m-d H:i:s',time());
                $account_detail->accounttype=10;
                $account_detail->servicetype=1002;
                $account_detail->originalfee=$fee;
                $account_detail->actualfee=$fee*0.9;
                $account_detail->subject='线上提问收入';
                $account_detail->ordertype=1;
                $account_detail->orderid=$jsonObj->orderid;
                $account_detail->createtime=date('Y-m-d H:i:s',time());
                Yii::error("account_detail is ".print_r($account_detail,1)."\n");
                $account_detail->save();



                //6.向用户发送模板消息
                $template = array();
                $template['data'] = array();

                $fromNickname=Expert::findOne($jsonObj->expertid)->name;
                $qa=QuestionAnswer::find()->select('userid')->where(['id' =>$jsonObj->questionid])->asArray()->one();
                $userid=$qa['userid'];
                Yii::error("qa is : ".print_r($qa,1)."\n");

                $toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
                Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");

                $content = isset($content)?$content:"点击下方查看详情";
                $first = '您好,'.$toUserInfo['nickname'].'! '.$fromNickname.'专家回答了您的问题，请前往芝麻找房收听';
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

                $url='http://www.zmzfang.com/weixin/Expert/Mine/AppointmentList.html';

                $template['touser'] = $toUserInfo['wxopenid'];
                $template['url']    = $url;
                if(!empty($toUserInfo['wxopenid'])){
                    $Wechatmodel = new Wechat();
                    $res = $Wechatmodel -> sendTemplateMessage($template);
                }else{
                    $res =[];
                }


                //7.向专家发送模板消息
                $template = array();
                $template['data'] = array();
                $toNickname=Expert::findOne($jsonObj->expertid)->name;
                $expert=Expert::find()->select('userid')->where(['id' =>$jsonObj->expertid])->asArray()->one();
                $expertuserid=$expert['userid'];
                $expertopenid=User::findOne($expertuserid)->wxopenid;
                
                $qa=QuestionAnswer::find()->select('userid')->where(['id' =>$jsonObj->questionid])->asArray()->one();
                $userid=$qa['userid'];
                Yii::error("qa is : ".print_r($qa,1)."\n");

                $toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
                Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");

                $fromNickname='芝麻找房';

                $content = isset($content)?$content:"点击下方查看详情";
                $first = '您好,'.$toNickname.'! 您回答'.$toUserInfo['nickname'].'的问题，钱款已经到帐，请前往芝麻找房查收';
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

                $url='http://www.zmzfang.com/weixin/Expert/Mine/Account.html';

                $template['touser'] = $expertopenid;
                $template['url']    = $url;
                if(!empty($expertopenid)){
                    $Wechatmodel = new Wechat();
                    $res = $Wechatmodel -> sendTemplateMessage($template);
                }else{
                    $res =[];
                }


                $arr['rscode']=$res['errcode'];
                $arr['filename']=$newname;
                return $arr;
        } catch(\Exception $e) {
                Yii::error("Audio::AddAudio error is ".$e->getMessage()."\n");
                $arr['rscode']=1;
                $arr['error']=$e->getMessage();
                return $arr;
        } 
    }


    public static function audioLen($jsonObj)
    {
        $model = new \common\helpers\getid3\getid3();
        $ThisFileInfo=$model->analyze($jsonObj->path);

        Yii::error("ThisFileInfo is ".print_r($ThisFileInfo,1)."\n");

        $arr['file_duration']=$ThisFileInfo['playtime_seconds'];
        $arr['rscode']=0;
        return $arr;
    }


    public static function AudioTest($jsonObj)
    {
        try{
                $expertAppointment=ExpertAppointment::find()->where(['id'=>$jsonObj->orderid,'validflag'=>1])->one();
                $fee=$expertAppointment->fee;
                Yii::error("fee is ".print_r($fee,1)."\n");

                $account=Account::find()->where(['userid'=>$jsonObj->expertid,'usertype'=>2])->one();
                Yii::error("account is ".print_r($account,1)."\n");
                if(empty($account)){
                    Yii::error("account not exist\n");
                    $arr['rscode']=1;
                    $arr['error']='account not exist';
                    return $arr;    
                }

                $account->historyincome=$account->historyincome+$fee;
                $account->historyprofit=$account->historyprofit+$fee*0.9;
                $account->remainedprofit=$account->remainedprofit+$fee*0.9;
                $account->save();

                

                $arr['rscode']=0;
                return $arr;
        }catch(\Exception $e) {
                Yii::error("Audio::AudioTest error is ".$e->getMessage()."\n");
                $arr['rscode']=1;
                $arr['error']=$e->getMessage();
                return $arr;
        } 
    }



} 
?>
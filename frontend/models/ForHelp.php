<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;
use frontend\models\Account;
use frontend\models\AccountDetail;

class ForHelp extends ActiveRecord
{
	public static function tableName()
    {
        return 't_requirement_help';
    }

    public static function addHelp($jsonObj)
    {
        $session = Yii::$app->session;
        $mid = $session->get('msgid');
        if($jsonObj->mid == $mid){
              return ['rscode'=>1];
        }else{
            $mid = $session->set('msgid',$jsonobj->mid);
        }
        $model = new static;
        $model->publishuserid =   $jsonObj->publishuserid;
        $model->publishusertype = $jsonObj->publishusertype;
        $model->requirementtype = $jsonObj->requirementtype;
        $model->region =          $jsonObj->region;
        $model->forhelpsubject =  $jsonObj->forhelpsubject;
        $model->level =           $jsonObj->level;
        $model->forhelpdetail =   $jsonObj->forhelpdetail;
        $model->rewardflag =      $jsonObj->rewardflag;
        $model->rewardfee =       $jsonObj->rewardfee;
        if($jsonObj->rewardfee==0){
            $model->status =          1;
        }else{
            $model->status =          0;
        }
        $model->replycnt =        0;
        $model->updatetime = $model->createtime = date('Y-m-d H:i:s',time());
        $model->validflag =       1;
        if($model->save()){
            return ['rscode'=>0,'helpid'=>$model->helpid,'rewardfee'=>$model->rewardfee];
        }else{
            return ['rscode'=>1];
        }
    }
    public static function modifyHelp($jsonObj){
        $model = static::findOne($jsonObj->helpid);
        $model->region =          $jsonObj->region;
        $model->forhelpsubject =  $jsonObj->forhelpsubject;
        $model->level =           $jsonObj->level;
        $model->forhelpdetail =   $jsonObj->forhelpdetail;
        if($model->rewardflag == 0){
            $model->rewardflag =  $jsonObj->rewardflag;
            $model->rewardfee =   $jsonObj->rewardfee;
        }
        $model->updatetime =      date('Y-m-d H:i:s',time());
        if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    public static function getHelpList($jsonObj){
        Yii::error("getHelpList:jsonObj is ".print_r($jsonObj,1)."\n");
        if($jsonObj->region!='%'){
            $region = substr($jsonObj->region,0,4).'__';
        }else{
            $region = $jsonObj->region;
        }
        $res=$model = static::find()->from('v_requirement_help')->where(['like','region',$region,false])->andWhere(['validflag'=>1])->andWhere(['status'=>1])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        Yii::error("getHelpList:res is ".print_r($res,1)."\n");
        return $res;
    }
    public static function getHelpListByUserid($jsonObj){
        $sql='SELECT helpid AS requirementid, publishuserid AS  userid, forhelpsubject, rewardfee AS price,IFNULL(bidcnt,0) AS bidcnt,createtime AS publishdate FROM t_requirement_help  LEFT OUTER JOIN   (SELECT helpid as requirementid,COUNT(helpid) AS bidcnt FROM t_help_reply where validflag = 1 GROUP BY requirementid) AS t_bidcnt ON t_bidcnt.requirementid=t_requirement_help.helpid  LEFT OUTER JOIN (SELECT agentflag, id AS userid FROM t_user GROUP BY userid) AS xx ON xx.userid=t_requirement_help.publishuserid WHERE t_requirement_help.publishuserid='.$jsonObj->userid.' AND t_requirement_help.validflag=1 AND t_requirement_help.status=1 limit '.$jsonObj->start.','.$jsonObj->count;
                Yii::trace("getRequirementList: ".$sql);
            return static::findBySql($sql)->asArray()->all();
    }
    public static function getHelpDetail($jsonObj){
        Yii::error("getHelpDetail:jsonObj is ".print_r($jsonObj,1)."\n");
        $res=static::find()->from('v_requirement_help')->where(['helpid'=>$jsonObj->helpid,'validflag'=>1])->asArray()->one();
        Yii::error("getHelpDetail:res is ".print_r($res,1)."\n");
        return $res;
    }
    public static function deleteHelp($jsonObj){
        $model = static::findOne(['helpid'=>$jsonObj->helpid,'publishuserid'=>$jsonObj->userid]);
        $model->validflag = 0;
        if($model->save()){
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }
    public static function acceptHelpReply($jsonObj){
        Yii::error("acceptHelpReply:jsonObj is ".print_r($jsonObj,1)."\n");
        $model = static::findOne(['helpid'=>$jsonObj->helpid,'publishuserid'=>$jsonObj->userid]);
        if(!$model->helpid){
            return ['rscode'=>1];
        }
        $model->adoptedreplyid =            $jsonObj->replyid;
        $model->adopttime =           date('Y-m-d H:i:s' ,time());
        $model->adoptedreplyuserid = $jsonObj->adoptuserid;
        if($model->save()){
            if(!$model->rewardflag){
                return ['rscode'=>0];
            }
            //用户account
            $Uaccount = \frontend\models\Account::find()->where(['userid'=>$jsonObj->userid])->one();
            if($Uaccount){
                $Uaccount->historyincome +=  $model->rewardfee;
                $Uaccount->historyprofit +=  $model->rewardfee*0.9;
                $Uaccount->remainedprofit += $model->rewardfee*0.9;
                $Uaccount->updatetime =      date('Y-m-d H:i:s',time());
                $Uaccount->save();
            }else{
                $toUserInfo=\frontend\models\User::find()->select('wxopenid,phone,wxunionid,id,nickname')->where(['id'=>$jsonObj->adoptedreplyuserid])->asArray()->one();
                $newAccount = new \frontend\models\Account();
                $newAccount->userid =         $jsonObj->adoptuserid;
                $newAccount->usertype =       1;
                $newAccount->openid =         $toUserInfo['wxopenid'];
                $newAccount->historyincome =  $model->rewardfee;
                $newAccount->historyprofit =  $model->rewardfee*0.9;
                $newAccount->drawedprofit =   0;
                $newAccount->usedprofit =     0;
                $newAccount->remainedprofit = $model->rewardfee*0.9;
                $newAccount->lockingprofit =  0;
                $newAccount->createtime =     date('Y-m-d H:i:s',time());
                $newAccount->updatetime =     date('Y-m-d H:i:s',time());
                $newAccount->save();
            }

            //新增账户 detail 表
            // $accountDetail = new \frontend\models\AccountDetail();
            // $accountDetail->userid =      $jsonObj->adoptuserid;/*最好多传adoptedreplyuserid字段*/
            // $accountDetail->usertype =    1;
            // $accountDetail->sumdate =     date('Y-m-d H:i:s',time());
            // $accountDetail->accounttype = 10;
            // $accountDetail->servicetype = 1008;
            // $accountDetail->originalfee = $model->rewardfee;
            // $accountDetail->actualfee =   $model->rewardfee*0.9;
            // $accountDetail->subject =     '求助收益';
            // $accountDetail->ordertype =   5;
            // $accountDetail->orderid =     /*订单号暂无*/
            // $accountDetail->createtime =  date('Ymd',time());
            // $accountDetail->save();
            // 最好采用事务型
            return ['rscode'=>0];
        }else{
            return ['rscode'=>1];
        }
    }

    public static function pushHelp($jsonObj){
        Yii::error("ForHelp::PushHelp jsonObj is ".print_r($jsonObj,1)."\n");
        //先根据需求id获取到需求详情，然后查找t_requirement_help记录里面的 region 字段
        $help = static::find()->where(['helpid'=>$jsonObj->helpid, 'validflag'=>1])->one();
        Yii::error("help is ".print_r($help,1)."\n");
        $content='您的区域有新的求助信息请查看';
        if($help->region)
        {
            $connection = Yii::$app->db;
            $sql='SELECT * FROM t_user WHERE FIND_IN_SET('.$help->region.',activeregion)';
            $command = $connection->createCommand($sql);
            $users = $command->queryAll();
            Yii::error("ForHelp::PushHelp users are ".print_r($users,1)."\n");
            ////发送模板消息
            foreach ($users as $user) {
                static::sendTemplateMessage($user['id'],$help->publishuserid,$content,$jsonObj->helpid);
            }
        }        
        $arr['recode']=0;
        return $arr;
    }



    public static function replyFee($jsonObj){
        Yii::error("ForHelp::replyFee jsonObj is ".print_r($jsonObj,1)."\n");

        $connection = Yii::$app->db;
        $sql='SELECT * FROM t_requirement_help WHERE helpid='.$jsonObj->helpid;
        Yii::error("ForHelp::replyFee sql is $sql\n");
        $command = $connection->createCommand($sql);
        $helpSubject = $command->queryAll();
        Yii::error("ForHelp::replyFee helpSubject is ".print_r($helpSubject,1)."\n");


        $toUserInfo=\frontend\models\User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$jsonObj->adoptuserid])->asArray()->one();
        Yii::error("ForHelp::replyFee toUserInfo is ".print_r($toUserInfo,1)."\n");

        $time = date('Y-m-d H:i:s',time());

        $accountDetail = new  \frontend\models\AccountDetail();
        $accountDetail->userid = $jsonObj->adoptuserid;
        $accountDetail->usertype= 1;
        $accountDetail->sumdate= date('Y-m-d H:i:s',time());
        $accountDetail->accounttype = '10';
        $accountDetail->servicetype = '1008';
        $accountDetail->originalfee = $helpSubject[0]['rewardfee'];
        $accountDetail->actualfee = $helpSubject[0]['rewardfee'];
        $accountDetail->subject ='求助答复收入';
        $accountDetail->ordertype = 5;
        $accountDetail->orderid = $jsonObj->helpid;
        $accountDetail->createtime = $time;
        $accountDetail->save();


        $userAccount = Account::find()->select('*')->where(['userid' =>$jsonObj->adoptuserid])->one();
        Yii::error("ForHelp::replyFee userAccount is ".print_r($userAccount,1)."\n");
        
        
        if($userAccount&&$helpSubject[0]['status']==1){
            $userAccount->historyincome += $helpSubject[0]['rewardfee'];
            $userAccount->historyprofit += $helpSubject[0]['rewardfee'];
            $userAccount->remainedprofit += $helpSubject[0]['rewardfee'];
            $userAccount->createtime = $time;
            $userAccount->updatetime = $time;
            $userAccount->save();
        }else{
            $newAccount = new Account();
            $newAccount->userid = $jsonObj->adoptuserid;
            $newAccount->usertype = 1;
            $newAccount->openid = $toUserInfo['wxopenid'];
            $newAccount->historyincome = $helpSubject[0]['rewardfee'];
            $newAccount->historyprofit = $helpSubject[0]['rewardfee'];
            $newAccount->remainedprofit = $helpSubject[0]['rewardfee'];
            $newAccount->drawedprofit =0;
            $newAccount->usedprofit = 0;
            $newAccount->lockingprofit =0;
            $newAccount->createtime = $time;
            $newAccount->updatetime = $time;
            $newAccount->save();
        }
           
        $arr['recode']=0;
        return $arr;
    }



    static function sendTemplateMessage($userid,$publishuserid,$content,$helpid)
        {
            //$userid是收信人，$publishuserid是发信人就是需求发布者，$conten是内容，$helpid是需求ID
            $template = array();
            $template['data'] = array();

            Yii::error("sendTemplateMessage: userid is $userid, publishuserid is $publishuserid, content is $content,
                orderid is $orderid\n");

            $userid=$userid;
            $fromNickname='芝麻找房';
            
            $url='http://www.zmzfang.com/weixin/HomePage/HelpDetail.html?helpId='.$helpid;
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

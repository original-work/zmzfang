<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Resume;
use common\models\Wechat;

class Recruit extends ActiveRecord
{
	public static function tableName()
    {
        return 't_recruit';
    }

    public function addRecruit($jsonObj)
    {
        try{
            Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");
            if($this->limit($jsonObj)){
                return ['rscode'=>1];
            }
            $recruit=new Recruit();
            $recruit->publishuserid=$jsonObj->publishuserid;
            //$recruit->publishusername=$jsonObj->publishusername;
            $recruit->usertype=$jsonObj->usertype;
            //$recruit->publishusertags=$jsonObj->publishusertags;
            //$recruit->organization=$jsonObj->organization;
            //$recruit->headpic=$jsonObj->headpic;
            //$recruit->organizationpic=$jsonObj->organizationpic;
            //$recruit->position=$jsonObj->position;
            Yii::error("addRecruit jsonObj recruitsubject is : ".$jsonObj->recruitsubject."\n");
            $recruit->recruitsubject=$jsonObj->recruitsubject;
            $recruit->recruitworkcity=$jsonObj->recruitworkcity;
            $recruit->location=$jsonObj->location;
            $recruit->recruitcount=$jsonObj->recruitcount;
            $recruit->workperiod=$jsonObj->workperiod;
             Yii::error("addRecruit jsonObj recruitposition is : ".$jsonObj->recruitposition."\n");
            $recruit->recruitposition=$jsonObj->recruitposition;
            $recruit->education=$jsonObj->education;
            $recruit->salary=$jsonObj->salary;
            $recruit->positiondetail=$jsonObj->positiondetail;
            $recruit->organizationinfo=$jsonObj->organizationinfo;
            $recruit->createtime=date('y-m-d H:i:s',time());
            $recruit->updatetime=date('y-m-d H:i:s',time());
            $recruit->expiretime=$jsonObj->expiretime;
            $recruit->expireinfo=$jsonObj->expireinfo;

            Yii::error("recruit begin save is ".print_r($recruit,1)."\n");
            $recruit->save();
            Yii::error("recruit after save is ".print_r($recruit,1)."\n");
            Yii::error("recruit id is ".print_r($recruit->recruitid,1)."\n");

            static::PushRecruit($recruit->recruitid);
            $arr['rscode']=0;
            return $arr;
        }catch (\Exception $e) {
            Yii::error("Recruit::addRecruit error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function modifyRecruit($jsonObj)
    {
        try{
            Yii::error("jsonObj is : ".print_r($jsonObj,1)."\n");

            $recruit=static::find()->where(['recruitid'=>$jsonObj->recruitid])->one();
            if(!empty($recruit))
            {
                // $recruit->publishuserid=$jsonObj->publishuserid;
                // $recruit->publishusername=$jsonObj->publishusername;
                // $recruit->usertype=$jsonObj->usertype;
                // $recruit->publishusertags=$jsonObj->publishusertags;
                // $recruit->organization=$jsonObj->organization;
                // $recruit->headpic=$jsonObj->headpic;
                // $recruit->organizationpic=$jsonObj->organizationpic;
                //$recruit->position=$jsonObj->position;
                $recruit->recruitsubject=$jsonObj->recruitsubject;
                $recruit->recruitworkcity=$jsonObj->recruitworkcity;
                $recruit->location=$jsonObj->location;
                $recruit->recruitcount=$jsonObj->recruitcount;
                $recruit->workperiod=$jsonObj->workperiod;
                $recruit->recruitposition=$jsonObj->recruitposition;
                $recruit->education=$jsonObj->education;
                $recruit->salary=$jsonObj->salary;
                $recruit->positiondetail=$jsonObj->positiondetail;
                $recruit->organizationinfo=$jsonObj->organizationinfo;
                $recruit->expiretime=$jsonObj->expiretime;
                $recruit->expireinfo=$jsonObj->expireinfo;
                Yii::error("modifyRecruit::recruit is ".print_r($recruit,1)."\n");
                $recruit->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("modifyRecruit::recruitid $jsonObj->recruitid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("Recruit::modifyRecruit error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function deleteRecruit($jsonObj)
    {
        try{
            Yii::error("deleteRecruit::jsonObj is : ".print_r($jsonObj,1)."\n");

            $recruit=static::find()->where(['recruitid'=>$jsonObj->recruitid])->one();
            if(!empty($recruit))
            {
                $recruit->validflag=0;

                Yii::error("deleteRecruit::recruit is ".print_r($recruit,1)."\n");
                $recruit->save();
                $arr['rscode']=0;
                return $arr;
            }else{
                Yii::error("deleteRecruit::recruitid $jsonObj->recruitid not exist \n");
                $arr['rscode']=1;
                return $arr;
            }
        }catch (\Exception $e) {
            Yii::error("Recruit::deleteRecruit error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }

    public static function getRecruitList($jsonObj)
    {
        Yii::error("getRecruitList::jsonObj is : ".print_r($jsonObj,1)."\n");
        /**
        $model = static::find()->select('recruitid,publishuserid,usertype,publishusertags,organization,headpic,organizationpic,position,recruitsubject,recruitworkcity,location,recruitcount,workperiod,recruitposition,education,salary,publishusername,organizationinfo')->where(['validflag'=>1]);
        foreach(['recruitworkcity','recruitposition','salary','workperiod'] as $v){
            if($jsonObj->$v){
                $m[$v] = $jsonObj->$v;
            }
        }
        if($m){
            $model->andWhere($m);
        }
        
        $res = $model->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        */

        foreach(['recruitworkcity','recruitposition','salary','workperiod'] as $v){
            if($jsonObj->$v){
                $m[$v] = $jsonObj->$v;
            }
        }
        if($m){
              $res = (new \yii\db\Query())->select('recruitid,publishuserid,usertype,organization,headpic,organizationlogo,position,recruitsubject,recruitworkcity,location,recruitcount,workperiod,recruitposition,education,salary,publishusername,organizationinfo')->from('v_recruit')->andWhere($m)->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->all();
        }
        else
        {
            $res = (new \yii\db\Query())->select('recruitid,publishuserid,usertype,organization,headpic,organizationlogo,position,recruitsubject,recruitworkcity,location,recruitcount,workperiod,recruitposition,education,salary,publishusername,organizationinfo')->from('v_recruit')->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->all();
        }

        Yii::error("getRecruitList:res is ".print_r($res,1)."\n");
        return $res;
    }

    public static function GetRecruitListByUserid($jsonObj)
    {
        Yii::error("GetRecruitListByUserid::jsonObj is : ".print_r($jsonObj,1)."\n");
        //$res=static::find()->select('publishuserid,usertype,publishusertags,organization,headpic,organizationpic,position,recruitsubject,location,recruitcount,workperiod,recruitposition,education,salary')->where(['publishuserid'=>$jsonObj->userid])->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->all();
        $res = (new \yii\db\Query())->select('publishuserid,usertype,organization,headpic,organizationlogo,position,recruitsubject,location,recruitcount,workperiod,recruitposition,education,salary')->from('v_recruit')->limit($jsonObj->count)->offset($jsonObj->start)->orderBy(['updatetime'=>SORT_DESC])->all();

        Yii::error("getRecruitListByUserid:res is ".print_r($res,1)."\n");
        return $res;
    }

    public static function GetRecruitCountByUserid($jsonObj)
    {
        Yii::error("GetRecruitCountByUserid::jsonObj is : ".print_r($jsonObj,1)."\n");
        $count = static::find()->where(['publishuserid'=>$jsonObj->userid,'validflag'=>1])->count();

        $arr['rscode'] = 0;
        $arr['count'] = $count;
        return $arr;
    }


    public static function GetMyRecruitList($jsonObj)
    {
        Yii::error("GetMyRecruitList::jsonObj is : ".print_r($jsonObj,1)."\n");
        //发布职位有限 直接返回所有职位
        //$res=static::find()->where(['publishuserid'=>$jsonObj->userid])->orderBy(['updatetime'=>SORT_DESC])->asArray()->all();
        $res = (new \yii\db\Query())->select('a.*')->from('v_recruit a')->where(['publishuserid'=>$jsonObj->userid])->all();
        Yii::error("GetMyRecruitList:res is ".print_r($res,1)."\n");
        return $res;
    }

    public static function GetRecruitDetail($jsonObj)
    {
        Yii::error("GetRecruitDetail::jsonObj is : ".print_r($jsonObj,1)."\n");
        try{
            //$recruit=static::find()->where(['recruitid'=>$jsonObj->recruitid])->asArray()->one();
            $recruit = (new \yii\db\Query())->select('a.*')->from('v_recruit a')->where(['recruitid'=>$jsonObj->recruitid])->one();
             Yii::error("GetRecruitDetail:res is ".print_r($res,1)."\n");
            return $recruit;
        }catch (\Exception $e) {
            Yii::error("Recruit::GetRecruitDetail error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }
    
    public static function GetRecruitListByRecommend($jsonObj)
    {
        Yii::error("GetRecruitListByRecommend::jsonObj is : ".print_r($jsonObj,1)."\n");
        try{
            $resume=Resume::find()->where(['id'=>$jsonObj->resumeid])->one();
            if(empty($resume))
            {
                Yii::error("GetRecruitListByRecommend: resumeid doesn't exist ".$e->getMessage()."\n");
                $arr['rscode']=1;
                return $arr;
            }
            $recruit=static::find()->where(['recruitposition'=>$resume->position])->asArray();

            $sql = sprintf("SELECT * FROM t_recruit WHERE recruitposition LIKE %s", "\"".$resume->position."\"");
            Yii::error("sql is ".$sql."\n");
            $connection = Yii::$app->db;
            $command = $connection->createCommand($sql);
            $recruit = $command->queryAll();
            Yii::error("recruit is ".print_r($recruit,1)."\n");
            return $recruit;        
        }catch (\Exception $e) {
            Yii::error("Recruit::GetRecruitListByRecommend error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }
    
    public static function PushRecruit($recruitid){

            Yii::error("Recruit::PushRecruit recruitid is ".print_r($recruitid,1)."\n");
            
            //先根据Recruitid获取到职位详情
            $recruit = static::find()->where(['recruitid'=>$recruitid, 'validflag'=>1])->one();
            Yii::error("recruit is ".print_r($recruit,1)."\n");
            Yii::error("Recruit::PushRecruit position is ".print_r($recruit->recruitposition,1)."\n");
            //增加向同职位或以上下职位同事推送的逻辑
            
            $content='职位详情，点击查看';

            if($recruit->recruitposition == '行政管理' || $recruit->recruitposition == '客服' || $recruit->recruitposition == '业务员' || $recruit->recruitposition == '置业顾问' || $recruit->recruitposition == '案场销售' || $recruit->recruitposition == '其他房产职位')
            {
                $extra = "position in ('行政管理','客服','业务员','置业顾问','案场销售','其他房产职位')";
            }
            else if($recruit->recruitposition == '客户经理' || $recruit->recruitposition == '客户主任' || $recruit->recruitposition == '房产评估师')
            {
                $extra = "position in ('行政管理','客服','业务员','置业顾问','案场销售','其他房产职位','客户经理','客户主任','房产评估师')";
            }
            else if($recruit->recruitposition == '店长' || $recruit->recruitposition == '销售总监')
            {
                $extra = "position in ('客户经理','客户主任','房产评估师','店长','销售总监')";
            }

            $recruitworkcity = "上海市";
            if(strstr($recruit->recruitworkcity,"上海市"))
            {
                $recruitworkcity = "上海市";
            }
            else if(strstr($recruit->recruitworkcity,"北京市"))
            {
                $recruitworkcity = "北京市";
            }
            else if(strstr($recruit->recruitworkcity,"广州市"))
            {
                $recruitworkcity = "广州市";
            }
            else if(strstr($recruit->recruitworkcity,"深圳市"))
            {
                $recruitworkcity = "深圳市";
            }
            else if(strstr($recruit->recruitworkcity,"杭州市"))
            {
                $recruitworkcity = "杭州市";
            }


            $connection = Yii::$app->db;
          
            //$sql='SELECT * FROM v_agent WHERE (userid = 10038) or ( city = .$.$extra.')';

            $sql = sprintf("SELECT * FROM v_agent WHERE city = %s and lastRecruitMsg < date_format(now(),%s) and (userid = 10038 or  (%s)) limit 10", "\"".$recruitworkcity."\"","'%Y%m%d'",$extra);

            //$sql='SELECT * FROM v_agent WHERE userid = 10145';
            Yii::error("Recruit::PushRecruit sql is $sql\n");
            $command = $connection->createCommand($sql);
            $users = $command->queryAll();
            //Yii::error("Recruit::PushRecruit users are ".print_r($users,1)."\n");
            //发送模板消息
            $u = array();
            foreach ($users as $user) {
                Yii::error("Recruit::PushRecruit userid: ".$user['userid']."\n");
                //$u[] = $user['userid'];
                array_push($u, $user['userid']);
                static::sendTemplateMessage($user['userid'],$content,$recruitid);
            }
            Yii::$app->db->createCommand()->update('t_user', ['lastRecruitMsg' => date('Ymd')], ['in','id',$u])->execute();

            $arr['recode']=0;
            return $arr;
    }


    static function sendTemplateMessage($userid,$content,$recruitid)
    {
        //$userid是收信人，$conten是内容，$supplymentid是需求ID
        $template = array();
        $template['data'] = array();

        Yii::error("sendTemplateMessage: userid is $userid,  content is $content,
            recruitid is $recruitid\n");

        $userid=$userid;
        $fromNickname='芝麻找房';
        
        $url='http://www.zmzfang.com/weixin/Recruit/PositionDetail.html?id='.$recruitid;
        Yii::error("case 1: userid is $userid, fromNickname is $fromNickname, url is $url\n");

        $toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
        Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");


        $content = isset($content)?$content:"点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您收到一条新的职位邀请';
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

    public function limit($obj){
        $c = static::find()->where(['publishuserid'=>$obj->userid,'validflag'=>1])->count();
        if($c > 2){
            return true;
        }else{
            return false;
        }
    }
}

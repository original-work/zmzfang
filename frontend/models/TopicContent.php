<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Wechat;

class TopicContent extends ActiveRecord
{
    public static function tableName()
    {
        return 't_topic_archive';
    }

    public static function pushTopic($topicid){
        Yii::error("Rent::pushTopic topicid is ".print_r($topicid,1)."\n");
        //随机获取3-5个经纪人
      
        $connection = Yii::$app->db;
        $sql='select * from t_user a where a.agentflag = 1 order by rand() limit 5;';
        $command = $connection->createCommand($sql);
        $users = $command->queryAll();
        Yii::error("Rent::pushTopic users are ".print_r($users,1)."\n");
        ////发送模板消息
        $content='有新的话题，邀请您的参与';
        $publishuserid = 0;
        foreach ($users as $user) {
            static::sendTemplateMessage($user['id'],$help->publishuserid,$content,$topicid);
        }
        
        $arr['recode']=0;
        return $arr;
    }

    static function sendTemplateMessage($userid,$publishuserid,$content,$topicid)
        {
            //$userid是收信人，$publishuserid是发信人就是需求发布者，$conten是内容，$topicid 是匿名话题id
            $template = array();
            $template['data'] = array();

            Yii::error("sendTemplateMessage: userid is $userid, publishuserid is $publishuserid, content is $content,
                orderid is $orderid\n");

            $userid=$userid;
            $fromNickname='芝麻找房';
            
            $url='http://www.zmzfang.com/weixin/Topic/shuoshuoList.html?id='.$topicid;
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
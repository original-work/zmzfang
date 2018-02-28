<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class WeiXinPic extends ActiveRecord
{
	public static function tableName()
    {
        return 't_wx_pic';
    }

    public static function getWeiXinPic($serverid)
    {
        return static::findAll(['serverid'=>$serverid]);
    }

    public static function audiofromURL($url,$directory,$rename)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close($ch);
        //$directory为存储目录
        $fp = fopen("$directory"."$rename",'w');
        fwrite($fp, $rawdata);
        fclose($fp);
    }

    public static function AddWxPic($jsonObj)
    {
        try{
            //1.插入数据
                $reqlist=WeiXinPic::getWeiXinPic($jsonObj->serverid);
                if(!empty($reqlist)){
                        $arr['rscode']=1;
                        $arr['error']='记录已经存在';
                        return $arr;
                }
                $req = new WeiXinPic();
                $req->type=$jsonObj->type;
                $req->userid=$jsonObj->userid;
                $req->houseid=$jsonObj->houseid;
                $req->housepicsn=$jsonObj->housepicsn;
                $req->serverid=$jsonObj->serverid;
                $req->localid=$jsonObj->localid;
                $req->url=$jsonObj->url;
                $req->status=$jsonObj->status;
                $req->updatetime=date('y-m-d H:i:s',time());
                $req->createtime=date('y-m-d H:i:s',time());
                $req->save();
                
            //2.根据serverid获取图片并保存到本地服务器
                $token = \common\models\Wechat::getWxAccessToken();
                Yii::error("token is ".$token."\n");

                $get_url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$token}&media_id={$jsonObj->serverid}";
                Yii::error("get_url is ".$get_url."\n");
                $time=time();
                $num = rand();
                $rename = $time.$num.".jpg";
                Yii::error("type is ".$jsonObj->type."\n");

                switch ($jsonObj->type){
                    case 1:
                        $directory = "/path/to/zmzfang/frontend/web/images/head/";
                        $fullname = "http://www.zmzfang.com/images/head/".$rename;
                        break;
                    case 2:
                        $directory = "/path/to/zmzfang/frontend/web/images/house/";
                        $fullname = "http://www.zmzfang.com/images/house/".$rename;
                        break;
                    case 3:
                        $directory = "/path/to/zmzfang/frontend/web/images/report/";
                        $fullname = "http://www.zmzfang.com/images/report/".$rename;
                        break;
                    case 4:
                        $directory = "/path/to/zmzfang/frontend/web/images/expertpicture/";
                        $fullname = "http://www.zmzfang.com/images/expertpicture/".$rename;
                        break;
                    case 5:
                        $directory = "/path/to/zmzfang/frontend/web/images/expertcard/";
                        $fullname = "http://www.zmzfang.com/images/expertcard/".$rename;
                        break;
                    case 6:
                        $directory = "/path/to/zmzfang/frontend/web/images/agentcard/";
                        $fullname = "http://www.zmzfang.com/images/agentcard/".$rename;
                        break;
                    default:
                        $arr['rscode']=1;
                        $arr['reason']="type $jsonObj->type error, tpye should be 1,2,3,4 or 5";
                        return $arr;
                }
     
                WeiXinPic::audiofromURL($get_url,$directory,$rename);

            //3.更新t_user表或者t_house_picture表
                $connection = Yii::$app->db;
                Yii::error("fullname is ".$fullname."\n");
                switch ($jsonObj->type){
                    case 1:
                        $sql = sprintf("UPDATE t_user SET picture=%s WHERE id=%s", "\"".$fullname."\"", $jsonObj->userid);
                        break;
                    case 2:
                        $sql = sprintf("UPDATE t_house_picture SET picture=%s WHERE houseid=%s AND sn=%s", "\"".$fullname."\"", $jsonObj->houseid, $jsonObj->housepicsn);
                        break;
                    case 3:
                        $sql = sprintf("UPDATE t_report_picture SET picture=%s WHERE reportid=%s AND sn=%s", "\"".$fullname."\"", $jsonObj->reportid, $jsonObj->housepicsn);
                        break;
                    case 4:
                        $sql = sprintf("UPDATE t_expert SET headpicture=%s WHERE id=%s", "\"".$fullname."\"", $jsonObj->userid);
                        break;
                    case 5:
                        $sql = sprintf("UPDATE t_expert SET businesscard=%s WHERE id=%s", "\"".$fullname."\"", $jsonObj->userid);
                        break;
                    case 6:
                        $sql = sprintf("UPDATE t_agent SET businesscard=%s WHERE userid=%s", "\"".$fullname."\"", $jsonObj->userid);
                        break;
                    default:
                        $arr['rscode']=1;
                        $arr['reason']="type $jsonObj->type error, tpye should be 1,2,3,4 or 5";;
                        return $arr;
                }

                Yii::error("sql is ".$sql."\n");
                $command = $connection->createCommand($sql);
                $command->execute();
                $arr['rscode']=0;
                return $arr;
        } catch(\Exception $e) {
                $arr['rscode']=1;
                $arr['error']=$e->getMessage();
                return $arr;
        } 
    }
    
}

?>
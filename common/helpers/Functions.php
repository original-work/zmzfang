<?php
namespace  common\helpers;

use Yii;
use common\models\Wechat;
use frontend\models\User;
use frontend\models\Expert;

/**
* 
*/
class Functions
{

	const PI ="3.1415926535898";
	const EARTH_RADIUS="6378.137";
	//整理返回接口数据
	static function setData($array) 
	{
		$return = array();
		$return['rescode'] = 0;
		$return['data'] = $array;
		return $return;
	}
	//【短信】 没有 openid 发短信 
	// 到微信检测未订阅 发短信  暂弃用
	// 模板消息发送失败 发短信
	

    static function sendSms($phone,$isSms = 0){
        // $phone='13601868340';
        //$word="收到$username给您的买房留言，登录微信号fangquwang或网站查看";
        $word="尊敬的用户，您的信息有新的更新，请登录微信公众平台\"芝麻找房\"进行查看。";
        if($isSms){
        	$word="尊敬的用户，您有新的聊天信息，请登录微信公众平台\"芝麻找房\"进行查看。";
        }
        $msguserid = 'fishytj';
        $account = 'jksc005';
        $pwd = "ytj1225";
        $content = rawurlencode($word);

        $httpstr = "http://sh2.ipyy.com/sms.aspx?action=send&userid=&account=$account&password=$pwd&mobile=$phone&content=$content&sendTime=&extno=";
        $model = new \common\helpers\Curl();
        $res = $model ->get($httpstr);
        return $res;
    }

    static function sendAuthSms($phone,$num,$seq){
        // $phone='13601868340';
        //$word="收到$username给您的买房留言，登录微信号fangquwang或网站查看";
        $word="您正在做注册操作，验证码:$num,序号:$seq,验证码有效期30分钟。";
        
        $msguserid = 'fishytj';
        $account = 'jksc005';
        $pwd = "ytj1225";
        $content = rawurlencode($word);

        $httpstr = "http://sh2.ipyy.com/sms.aspx?action=send&userid=&account=$account&password=$pwd&mobile=$phone&content=$content&sendTime=&extno=";
        $model = new \common\helpers\Curl();
        $res = $model ->get($httpstr);
        return $res;
    }

    static function caution($words){
        $phone='13601868340';
        $msguserid = 'fishytj';
        $account = 'jksc005';
        $pwd = "ytj1225";
        $content = rawurlencode($words);

        $httpstr = "http://sh2.ipyy.com/sms.aspx?action=send&userid=&account=$account&password=$pwd&mobile=$phone&content=$content&sendTime=&extno=";
        $model = new \common\helpers\Curl();
        $res = $model ->get($httpstr);
        return $res;
    }
    //计算范围，可以做搜索用户
    static function getRange($lat,$lon,$raidus){
		//计算纬度
		$degree = (24901 * 1609) / 360.0;
		$dpmLat = 1 / $degree;
		$radiusLat = $dpmLat * $raidus;
		$minLat = $lat - $radiusLat; //得到最小纬度
		$maxLat = $lat + $radiusLat; //得到最大纬度
		  //计算经度
		$mpdLng = $degree * cos($lat * (self::PI / 180));
		$dpmLng = 1 / $mpdLng;
		$radiusLng = $dpmLng * $raidus;
		$minLng = $lon + $radiusLng; //得到最小经度
		$maxLng = $lon - $radiusLng; //得到最大经度
		  //范围
		$range = array(
		    'minLat' => $minLat,
		    'maxLat' => $maxLat,
		    'minLon' => $minLng,
		    'maxLon' => $maxLng
		 	);
		return $range;
	}
	//获取2点之间的距离
	// static function getDistance($lat1, $lng1, $lat2, $lng2){
	// 	$radLat1 = $lat1 * (self::PI / 180);
	// 	$radLat2 = $lat2 * (self::PI / 180);
	// 	$a = $radLat1 - $radLat2;
	// 	$b = ($lng1 * (self::PI / 180)) - ($lng2 * (self::PI / 180));
	// 	$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
	// 	$s = $s * self::EARTH_RADIUS;
	// 	$s = round($s * 10000) / 10000;
	// 	return $s;
	// }

	// static function getDistance2($lng1, $lat1, $lng2, $lat2){
	// 	$ejd = 102834.74258026089786013677476285;
	// 	$ewd = 111712.69150641055729984301412873;
	// 	$a = abs(($lng1 - $lng2) * $ewd);
	// 	$b = abs(($lat1 - $lat2) * $ejd);
	// 	return sqrt(($a *$a + $b * $b));
	// }
	static function getDistance3($fP1Lon, $fP1Lat, $fP2Lon, $fP2Lat){
	    $fEARTH_RADIUS = 6378137;
	    //角度换算成弧度
	    $fRadLon1 = deg2rad($fP1Lon);
	    $fRadLon2 = deg2rad($fP2Lon);
	    $fRadLat1 = deg2rad($fP1Lat);
	    $fRadLat2 = deg2rad($fP2Lat);
	    //计算经纬度的差值
	    $fD1 = abs($fRadLat1 - $fRadLat2);
	    $fD2 = abs($fRadLon1 - $fRadLon2);
	    //距离计算
	    $fP = pow(sin($fD1/2), 2) +
	          cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
	    return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
	}

	static function getUserIp(){
		if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) 
        { 
            $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; 
        } 
        elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) 
        { 
            $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"]; 
        }
        elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) 
        { 
            $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
        } 
        elseif (getenv("HTTP_X_FORWARDED_FOR")) 
        { 
            $ip = getenv("HTTP_X_FORWARDED_FOR"); 
        } 
        elseif (getenv("HTTP_CLIENT_IP")) 
        { 
            $ip = getenv("HTTP_CLIENT_IP"); 
        } 
        elseif (getenv("REMOTE_ADDR"))
        { 
            $ip = getenv("REMOTE_ADDR"); 
        } 
        else 
        { 
            $ip = "0.0.0.0"; 
        }
        return $ip;
	}




	static function sendTemplateMessage($type,$userid,$expertid,$content,$orderid,$appointmenttype)
    {
        // $model = new Functions();
        $template = array();
        $template['data'] = array();

        Yii::error("sendTemplateMessage: type is $type, userid is $userid, expertid is $expertid, content is $content,
            orderid is $orderid, appointmenttype is $appointmenttype\n");

        switch ($type) {
	        case 1://type=1,向user发送消息,根据userid到t_user表中获取wxopenid
	        	$userid=$userid;
	        	$fromNickname=User::findOne($expertid)->nickname;
	        	$fromUserid=$expertid;
                if($appointmenttype==1){
                    $url='http://www.zmzfang.com/weixin/Expert/Mine/MyAppointmentDetail.html?orderId='.$orderid;
                }elseif($appointmenttype==2){
                    $url='http://www.zmzfang.com/weixin/Expert/Mine/MyAppointmentDetailOffline.html?orderId='.$orderid;
                }
	        	Yii::error("case 1: userid is $userid, fromNickname is $fromNickname, fromUserid is $fromUserid\n");
		        break;
		    case 2://type=2,向expert发送消息,首先根据expertid到t_expert表中找到对应的userid，然后根据userid到t_user表中获取wxopenid
		    	$userid=Expert::findOne($expertid)->userid;
		    	$fromNickname=User::findOne($userid)->nickname;
	        	$fromUserid=$userid;
                if($appointmenttype==1){
                    $url='http://www.zmzfang.com/weixin/Expert/Mine/AppointmentMeDetail.html?orderId='.$orderid;
                }elseif($appointmenttype==2){
                    $url='http://www.zmzfang.com/weixin/Expert/Mine/AppointmentMeDetailOffline.html?orderId='.$orderid;
                }
	        	Yii::error("case 2: userid is $userid, fromNickname is $fromNickname, fromUserid is $fromUserid\n");
		        break;
		    default:
		    	break;
		}
		$toUserInfo=User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$userid])->asArray()->one();
        Yii::error("toUserInfo is : ".print_r($toUserInfo,1)."\n");

    	$connection = Yii::$app->db;
        $sql = sprintf("UPDATE t_user SET havemsg=havemsg+1 WHERE id=%s;",$userid);
        Yii::error("sql is $sql\n");
        $command = $connection->createCommand($sql);
        $command->execute();

        $content = isset($content)?$content:"点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您有一条新的消息请查收';
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,$fromNickname,date('Y-m-d',time()),$content];
        $col = [];
        // $url = 'http://www.zmzfang.com/?r=door/scope&view=Message/im-chat&id='.$fromUserid.'&nickname='.$fromNickname;

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
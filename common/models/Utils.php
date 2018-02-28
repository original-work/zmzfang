<?php

namespace common\models;
use \common\helpers\Functions;


class Utils 
{
    public static function SortByDist($objs,$longitude,$latitude)
    {
    			$redis = new \redis();
				$redis->connect('127.0.0.1',6379);
				$idx=0;
				foreach ($objs as $obj) {
				    $redis->geoadd('sortedobjlistbydist',$obj->longitude,$obj->latitude,$idx++);
				}
				$geolist=$redis->georadius('sortedobjlistbydist',$longitude,$latitude,'3','km',['WITHDIST','ASC']);
       			$count=$redis->del('sortedobjlistbydist');
				$redis->close();
				
				return $geolist;
    }
    
    public static function GetObjSortByDist($objs,$longitude,$latitude,$dist)
    {
    			$redis = new \redis();
				$redis->connect('127.0.0.1',6379);
				$idx=0;
				foreach ($objs as $obj) {
				    $redis->geoadd('sortedobjlistbydist',$obj->longitude,$obj->latitude,$idx++);
				}
				$geolist=$redis->georadius('sortedobjlistbydist',$longitude,$latitude,$dist,'km',['WITHDIST','ASC']);
        		$count=$redis->del('sortedobjlistbydist');
				$redis->close();
				
				return $geolist;
    }
    
    public static function GetDistByTwoPonit($longitude_src,$latitude_src,$longitude,$latitude)
    {
    			$redis = new \redis();
				$redis->connect('127.0.0.1',6379);
				$idx=0;
				$dist=500;
				$redis->geoadd('sortedobjlistbydist',$longitude_src,$latitude_src,$idx);
				$geolist=$redis->georadius('sortedobjlistbydist',$longitude,$latitude,$dist,'km',['WITHDIST','ASC']);
        		$count=$redis->del('sortedobjlistbydist');
				$redis->close();
				
				return $geolist;
    }
    
    
    public static function GetVerificationCode($phonenumber)
    {
    
    	/**	  
		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		if ( $sock === false ) {
		    $msg = socket_strerror( socket_last_error() );
		    \Yii::info("socket_create() failed:reason:".$msg."\n");
		}
		
		$seq=1;
		$request=0;
		$msg = $seq.",".$request.",".$phonenumber.",".static::safeEncoding("芝麻找房");
		$len = strlen($msg);
		socket_sendto($sock, $msg, $len, 0, '139.196.105.189', 20001);
		socket_recvfrom($sock, $inMsg, 1024, 0, $from, $port);
		$array = explode(",",$inMsg);
		$secseq = $array[2];
		socket_close($sock);
		
		$retstr = array('secseq'=>$secseq);
		return $retstr;
		**/
		$redis=new \Redis();
		$redis->connect('localhost','6979');

		$num = rand(1000,9999);
		$redis->setex($phonenumber,1800,$num);

		$seq = rand(1,100);

		$res=Functions::sendAuthSms($phonenumber,$num,$seq);
		$retstr = array('secseq'=>$seq);
		$redis->close();
		return $retstr;

    }
    
    public static function VerifyVerificationCode($secseq,$vcode,$phonenumber)
    {
    	/*
    			$seq = 111; 
				$request = 1;

				$msg = $seq.",".$request.",".$secseq.",".$vcode;
				\Yii::error("Utils:VerifyVerificationCode msg is $msg\n");
				$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
				if ( $sock === false ) {
				    $msg = socket_strerror( socket_last_error() );
				    \Yii::info("socket_create() failed:reason:".$msg."\n");
				}
					
				$len = strlen($msg);
				socket_sendto($sock, $msg, $len, 0, '139.196.105.189', 20001);									
				socket_recvfrom($sock, $inMsg, 1024, 0, $from, $port);				
				$array = explode(",",$inMsg);
				$rscode = $array[2];
				socket_close($sock);
				\Yii::error("Utils:VerifyVerificationCode rscode is $rscode\n");
				$retstr = array('rscode'=>$rscode);
		*/
				$redis=new \Redis();
				$redis->connect('localhost','6979');
				$redisVcode = $redis->get($phonenumber);
				$rscode = 1;//失败
				if(!empty($redisVcode))
				{
					\Yii::error("Utils:VerifyVerificationCode mdn=$phonenumber vcode=$vcode redisVcode=$redisVcode \n");
					if($redisVcode == $vcode)
					{
						$rscode = 0;
					}
				}
				else
				{
					\Yii::error("Utils:VerifyVerificationCode mdn=$phonenumber vcode=$vcode redisVcode is null \n");
				}
				$redis->close();
				$retstr = array('rscode'=>$rscode);
				return $retstr;
    }
    
    public static function send_post($url, $post_data) {  
		$ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($post_data))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);    
		}  
		
		public static function safeEncoding($string,$outEncoding ='GB2312') 
		{ 
				$encoding = "UTF-8"; 
				for($i=0;$i<strlen($string);$i++) 
				{ 
						if(ord($string{$i})<128) 
								continue; 
						
						if((ord($string{$i})&224)==224) 
						{ 
								//第一个字节判断通过 
								$char = $string{++$i}; 
								if((ord($char)&128)==128) 
								{ 
										//第二个字节判断通过 
										$char = $string{++$i}; 
										if((ord($char)&128)==128) 
										{ 
											$encoding = "UTF-8"; 
											break; 
										} 
								} 
						} 
						
						if((ord($string{$i})&192)==192) 
						{ 
								//第一个字节判断通过 
								$char = $string{++$i}; 
								if((ord($char)&128)==128) 
								{ 
								// 第二个字节判断通过 
								$encoding = "GB2312"; 
								break; 
								} 
						} 
				} 

				if(strtoupper($encoding) == strtoupper($outEncoding)) 
						return $string; 
				else 
						return iconv($encoding,$outEncoding,$string); 
		}
}

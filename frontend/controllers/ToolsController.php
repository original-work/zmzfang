<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
include 'phpqrcode/phpqrcode.php';    

class ToolsController extends Controller
{
	public $enableCsrfValidation = false;
	function actionResults(){
        if($_POST[action]=="rate")
        {
            $totalprice = $_POST['totalprice'];
            $totalarea = $_POST['totalarea'];
            $originalprice = $_POST['originalprice'];
            $type = $_POST['type'];
            $fivebuyhome = $_POST['fivebuyhome'];
            //契税
            if(!$_POST['firstbuyhome']){
                $qfee=$totalprice*0.03;
            }else{
                if($type==0){
                    if($totalarea<90){
                        $qfee=$totalprice*0.01;
                    }elseif($totalarea>=90){
                        $qfee=$totalprice*0.015;
                    }
                }else{
                    $qfee=$totalprice*0.03;
                }
            }
            
            
            //交易手续费
            $jfee=$totalarea*2.5;
            

            //印花贴票5 登记费80
            

            //增值税
            if($fivebuyhome>=2){  //满2
                if($type==0){  //满2标
                    $yfee=0;
                }else{  //满2非标
                    // if( (($totalprice-$originalprice)*0.0555) > ($totalprice*0.0555) ){
                    //     $yfee=$totalprice*0.0555;
                    // }else{
                    //     $yfee=($totalprice-$originalprice)*0.0555;
                    // }
                    $yfee=($totalprice-$originalprice)/1.05*0.05;
                }
                
            }else{  //不满2
                $yfee=$totalprice/1.05*0.05;
            }
            if($yfee<0){$yfee=0;}
            
            //个税
            if($fivebuyhome==5&&$_POST['onlybuyhome']==1){
                $gfee=0;
            }else{
                if($type==0){
                    $gfee=$totalprice*0.01;
                }else{
                    $gfee=$totalprice*0.02;
                }
                
            }
            $sellSum = $gfee*10000 + $yfee*10000 + $jfee;
            $buySum = $qfee*10000 + $jfee + 80;
            //$sum=$qfee*10000+$jfee*2+80+$yfee*10000+$gfee*10000;
            $sum = $sellSum + $buySum;

            echo "卖方<br>";
            echo "个人所得税：".round($gfee,2)."万<br>";
            echo "增值税：".round($yfee,2)."万<br>"; 
            echo "交易手续费：".ceil($jfee)."元<br>";
            echo "卖方总税费：".ceil($sellSum)."元<br>";

            echo "买方<br>";
            echo "契税：".round($qfee,2)."万<br>";
            echo "交易手续费：".ceil($jfee)."元<br>";
            echo "登记费：80元<br>";
            echo "买方总税费：".ceil($buySum)."元<br>";
            echo "合计税费：".ceil($sum)."元";
        }
        else if($_POST[action]=="canbuy")
        {
            $_POST[before]=(int)$_POST[before];
            $_POST[after]=(int)$_POST[after];
            $_POST[child]=(int)$_POST[child];
            $_POST[peiou]=(int)$_POST[peiou];
            $_POST[peioua]=(int)$_POST[peioua];

            if($_POST[type]==0){  //上海户口
                $can=2;
                    if($_POST[ismarry]==0){  //单身
                        $can=1;
                        if($_POST[before]>2){  
                            $can=0;
                        }else{
                            if($_POST[after]==0){
                                $can=1;
                            }else{
                                $can=0;
                            }  //end after
                        }  //end before
                    }else{   //已婚
                        if($_POST[before]==3){
                            $can=1;
                        }elseif($_POST[before]>3){
                            $can=0;
                        }elseif($_POST[before]<=2){
                            
                        }
                    }// end 婚姻
            }elseif($_POST[type]==1){
                $can=1;
                if($_POST[ismarry]==0){  //单身
                        $can=0;
                    }else{   //已婚
                        if($_POST[before]>0||$_POST[after]>0||$_POST[child]>0){
                            $can=0;
                        }else{
                            $can=1;
                        }
                    }
            }else{
                $can=1;
            }
            if($_POST[after]==1){
                $can-=1;
            }elseif($_POST[after]>1){
                $can-=2;
            }
            if($_POST[peiou]>3){
                $can-=2;
            }elseif($_POST[peiou]==3){
                $can-=1;
            }
            if($_POST[child]>=2){
                $can-=2;
            }elseif($_POST[child]==1){
                $can-=1;
            }
            if($_POST[child2]>=1){
                $can-=2;
            }
            if($can>0){
            echo "恭喜，您还可购买".$can."套";
            }else{
            echo "对不起，您已经被限购了，无法购买！";
            }
        }
    }
    /*
        手工推送给仟房
    */ 
    function actionCdSubmit(){
        exit;
        $area = $_POST['area'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $appid = '4d71b19e67';
        $method = 'submit';
        $token = '68ab09aee3fb14eb959f635a904744ef';
        $strs = "address=".$address."&appid=".$appid."&area=".$area."&mobile=".$mobile."&timestamp=".time();
        $sign = strtolower(md5($strs.$token));
        $data = \common\helpers\Curl::http_curl(
            "http://www.1001fang.com/cdapi/".$method."/?".$strs."&sign=".$sign
        );
        // $data['sign'] = $sign; 
        // $data['strs'] = $strs;
        // $data['timestamp'] = time();
        // $data['url'] = "http://www.1001fang.com/cdapi/".$method."/?".$strs."&timestamp=".time()."&appid=".$appid."&sign=".$sign;
        return $data;
        // {"code":1,"response":{"id":"60083"}}
    }
    function actionGetorder($orderid){
        return json_encode( \frontend\models\Cd::find()->asArray()->where(['orderid'=>$orderid])->one());
    }
    function actionMycd(){
        // exit;
        $openid = $_POST['openid'];
        $model =new \frontend\models\Cd();
        $data = $model::find()->where(['openid'=>$openid])->asArray()->all();
        $res['code'] = 1;
        $res['response'] = $data;
        return  json_encode($res);
    }
    function actionCdSearch(){
        // exit;
        $id = $_POST['id'];
        $appid = '4d71b19e67';
        $method = 'query';
        $token = '68ab09aee3fb14eb959f635a904744ef';
        $strs = "appid=".$appid."&id=".$id."&timestamp=".time();
        $sign = strtolower(md5($strs.$token));
        $data = \common\helpers\Curl::http_curl(
            "http://www.1001fang.com/cdapi/".$method."/?".$strs."&sign=".$sign
        );
        return  json_encode($data);
    }

    function actionErweima(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);

        $errorCorrectionLevel = 'L';//容错级别   
        $matrixPointSize = 6;//生成图片大小   
        //生成二维码图片   
        \QRcode::png($obj->url, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);   
        $logo = $obj->pic;//准备好的logo图片   
        $QR = 'qrcode.png';//已经生成的原始二维码图   

        if ($logo !== FALSE) {   
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            if (imageistruecolor($logo)){
                imagetruecolortopalette($logo, false, 65535);
            }
            $QR_width = imagesx($QR);//二维码图片宽度   
            $QR_height = imagesy($QR);//二维码图片高度   
            $logo_width = imagesx($logo);//logo图片宽度   
            $logo_height = imagesy($logo);//logo图片高度   
            $logo_qr_width = $QR_width / 5;   
            $scale = $logo_width/$logo_qr_width;   
            // $logo_qr_height = $logo_height/$scale;
            $logo_qr_height = $QR_height / 5;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            $from_height =  ($QR_height - $logo_qr_height) / 2;
            Yii::error("QR_width is $QR_width\n");
            Yii::error("QR_height is $QR_height\n");
            Yii::error("logo_width is $logo_width\n");
            Yii::error("logo_height is $logo_height\n");
            Yii::error("logo_qr_width is $logo_qr_width\n");
            Yii::error("scale is $scale\n");
            Yii::error("logo_qr_height is $logo_qr_height\n");
            Yii::error("from_width is $from_width\n");
            Yii::error("from_height is $from_height\n");

            //重新组合图片并调整大小   
            imagecopyresampled($QR, $logo, $from_width, $from_height, 0, 0, $logo_qr_width,   
            $logo_qr_height, $logo_width, $logo_height);   
        }   
        //输出图片   
        imagepng($QR, 'codetc.png');
        $res['rscode']=0;
        $res['pic']='<img src="http://www.zmzfang.com/codetc.png">';

        return json_encode($res);
    }
}
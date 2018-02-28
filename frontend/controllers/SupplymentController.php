<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Supplyment;
use frontend\models\ApartmentPicture;
use frontend\models\UserOperate;

class SupplymentController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex($userid)
    {
        header("Content-type:json/application;charset=utf-8");
        $model = new Supplyment();
    }

    public function actionGetMyHouse()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Supplyment::GetMyHouse($obj);
        return json_encode($res);
    }

    public function actionGetHouseDetail()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res1=Supplyment::GetHouseDetail($obj);
        Yii::error("res1 is ".print_r($res1[0],1)."\n");
        $res2=ApartmentPicture::GetHouseDetail($obj);
        Yii::error("res2 is ".print_r($res2,1)."\n");
        $res=array(
            "houseid"=>$res1[0][houseid],
            "userid"=>$res1[0][userid],
            "districtid"=>$res1[0][districtid],
            "districtname"=>$res1[0][districtname],
            "housenumber"=>$res1[0][housenumber],
            "roomnumber"=>$res1[0][roomnumber],
            "buildingarea"=>$res1[0][buildingarea],
            "expectsaleprice"=>$res1[0][expectsaleprice],
            "storey"=>$res1[0][storey],
            "totalstorey"=>$res1[0][totalstorey],
            "roomcnt"=>$res1[0][roomcnt],
            "hallcnt"=>$res1[0][hallcnt],
            "bathroomcnt"=>$res1[0][bathroomcnt],
            "houseage"=>$res1[0][houseage],
            "buildingtype"=>$res1[0][buildingtype],
            "decorationtype"=>$res1[0][decorationtype],
            "orientation"=>$res1[0][orientation],
            "detail"=>$res1[0][detail],
            "schooldistrictflag"=>$res1[0][schooldistrictflag],
            "metroflag"=>$res1[0][metroflag],
            "owneronlyflag"=>$res1[0][owneronlyflag],
            "publishdate"=>$res1[0][publishdate],
            "overfiveonlyflag"=>$res1[0][overfiveonlyflag],
            "city"=>$res1[0][city],
            "picture"=>$res2
        );
        
        //增加日志记录
        if($obj->userid)
        {
            $options['userid'] = $obj->userid;
            $options['type'] = 33;
            $options['dstid'] = $obj->houseid;
            $options['dstuserid'] = $res['userid'];
            $options['city'] = empty($obj->city)?'上海市':$obj->city;

            UserOperate::addUserLog($options);
        }
        
        
        return json_encode($res);
    }

    public function actionGetMatchHouseList()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        Yii::trace("obj is ".print_r($obj,1)."\n");
        $res=Supplyment::GetMatchHouseList($obj);
        return $res;
    }


    public function actionDelHouseByHouseid()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        Yii::trace("obj is ".print_r($obj,1)."\n");
        $res=Supplyment::DelHouseByHouseid($obj);
        return json_encode($res);
    }


    public function actionPushSupplyment()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        Yii::error("obj is ".print_r($obj,1)."\n");
        $res=Supplyment::PushSupplyment($obj);
        return json_encode($res);
    }
    public function actionYdSet(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::set($obj);
        return json_encode($res);
    }
    public function actionYdGet(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::get($obj);
        return json_encode($res);
    }
    public function actionYdDetail(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::detail($obj);
        return json_encode($res);
    }
    public function actionYdDelete(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::DelHouse($obj);
        return json_encode($res);
    }
    public function actionYdGetListByUserid(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::getListByUserId($obj);
        return json_encode($res);
    }

    public function actionGetYdHouseList(){
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=\frontend\models\YdHouse::getHouseList($obj);
        return json_encode($res);
    }

    function actionHousePicUpload(){
        $base64 = $_POST['base64'];
        $count = count($base64);
        
        for($i=0;$i<$count;$i++){
            $s = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64[$i]['base64']));
            $rand = rand(1000, 9999);
            $filename = date("YmdHis",time()) . $rand .'.jpg';
            $res[$i]['picname'] = 'http://www.zmzfang.com/images/house/'.$filename;
            $res[$i]['status'] = file_put_contents("../web/images/house/".$filename, $s);
            $res[$i]['sn'] = $base64[$i]['sn'];
        }
        return json_encode($res);
    }
    
}

?>

<?php
namespace common\models;
use Yii;
use yii\web\UploadedFile;
use yii\base\Model;

class Upload extends Model
{
	public $imageFile;

	public function rules()
	   {
	       return [
	           [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
	       ];
	   }
	   
	public function upload($id,$path,$callback,$filename = null)
	   {
	       if ($this->validate()) {
	       	   $filename = $filename?iconv('utf-8','gb2312',$filename) : date('ymdhis');
	       	   $file = $path . $filename . '.' . $this->imageFile->extension;
	           $this->imageFile->saveAs($file);
	           $picPath = $filename. '.' .$this->imageFile->extension;
	           $this->$callback($id,$picPath);
	           return true;
	       } else {
	           return false;
	       }
	   }
	private function topicUpload($id,$picPath){
		$model = \frontend\models\Topic::findOne($id);
	           // var_dump($model);
	    $model->picture = $picPath;
	    $model->save();
	}
	// http://www.zmzfang.com/images/expertpicture/1476876056110270781.jpg
	private function expertUpload($id,$picPath){
		$model = \frontend\models\Expert::findOne($id);
	           // var_dump($model);
	    $model->headpicture = 'http://www.zmzfang.com/images/expertpicture/'.$picPath;
	    $model->save();
	}
	// http://www.zmzfang.com/images/expertcard/14773798461306144261.jpg
	private function expertBussinessUpload($id,$picPath){
		$model = \frontend\models\Expert::findOne($id);
	           // var_dump($model);
	    $model->businesscard = 'http://www.zmzfang.com/images/expertcard/'.$picPath;
	    $model->save();
	}

	private function orgLogoUpload($id,$picPath){
		$model = \frontend\models\OrgLogo::findOne($id);
	           // var_dump($model);
	    $model->organizationlogo = 'http://www.zmzfang.com/weixin/pic/'.$picPath;
	    $model->save();
	}
}
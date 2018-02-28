<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use \frontend\models\TopicContent;
use \frontend\models\Topic;
use \frontend\models\TopicPl;

class TopicController extends Controller
{
	public $enableCsrfValidation = false;
/**
 * Topic/index.html
 * 增加话题阅读量
 */
	function actionReadup(){
		$rows = Topic::findOne($_POST['id']);
		$rows->read += 1;
		$rows->save();
		return json_encode(['code'=>1]);
	}

	function actionGetReadTimes(){
		$data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        Yii::error("id is : ".$obj->id."\n");
		$rows = Topic::findOne($obj->id);
		Yii::error("ReadTimes is : ".$rows->read."\n");
		$res['read']=$rows->read;
		return json_encode($res);
	}

/**
 * Topic/list.html
 * 话题列表
 */
	function actionGetTopicList(){
		$data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
		$rows = Topic::find()
		->where(['status' => 1])
		->orderby(['id'=>SORT_DESC])
		->limit($obj->count)
		->offset($obj->start)
		->asArray()
		->all();
		$res['code'] = 1;


		$res['data'] = $rows;
		// foreach ($rows as $k => $row) {
		// 	$res['data'][$k] = $rows[$k]->attributes;
		// 	$res['data'][$k]['gd_count'] = count($rows[$k]->relatedRecords['count']);
		// }
		return json_encode($res);
	}
	function actionContent(){
		$id = intval($_POST['id']);
		return json_encode(Topic::find()->where(['id'=>$id])->asArray()->One());
	}
/*
HomePage/index.html 首页话题
*/
	function actionLastContent(){
		$res = Topic::find()->select('id,title,count,picture,read')->where(['status'=>"1"])->limit(4)->orderby(['id'=>SORT_DESC])->asArray()->all();
		// $res[0]['gd_count'] = TopicContent::find()->where(['topic_id'=>$res[0]['id']])->count();  因为调整 不要观点数了 只要阅读量
		return json_encode($res);
	}
/*
Topic/index.html 热门资讯
*/
	function actionTopReadContent(){
		$res = Topic::find()->select('id,title,count,picture,read')->where(['and',['status'=>"1"],['>','read',100]])->limit(5)->orderby(['id'=>SORT_DESC])->asArray()->all();
		// $res[0]['gd_count'] = TopicContent::find()->where(['topic_id'=>$res[0]['id']])->count();  因为调整 不要观点数了 只要阅读量
		return json_encode($res);
	}
	function actionContentList(){
		$id = intval($_POST['id']);
		$page = intval($_POST['page']);
		if($page == 1){
			$data['recommend'] = TopicContent::find()->select('t_user.nickname,t_user.picture,t_topic_archive.*')->where(['topic_id'=>$id])->leftjoin('t_user','t_user.id = t_topic_archive.user_id')->limit(2)->orderby(['zan'=>SORT_DESC])->asArray()->all();
		}
		$data['data'] = TopicContent::find()->select('t_user.nickname,t_user.picture,t_topic_archive.*')->where(['topic_id'=>$id])->leftjoin('t_user','t_user.id = t_topic_archive.user_id')->limit(20)->orderby(['time'=>SORT_DESC])->offset(($page-1)*20)->asArray()->all();
		// var_dump($data);
		return json_encode($data);
	}
	function actionShuoshuoList(){
		$data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
		// if($page == 1){
		// 	$data['recommend'] = TopicContent::find()->where(['topic_id'=>$id])->andWhere(['>','time',strtotime("-1 week")])->limit(3)->orderby(['zan'=>SORT_DESC])->asArray()->all();
		// }
		$res['data'] = TopicContent::find()->where(['topic_id'=>$obj->id])->limit($obj->count)->orderby(['lastime'=>SORT_DESC,'time'=>SORT_DESC])->offset($obj->start)->asArray()->all();
		// var_dump($data);
		return json_encode($res);
	}
	function actionTContent(){
		$id = intval($_POST['id']);
		$tid = intval($_POST['tid']);

		$data['data'] = TopicContent::find()->select('t_user.nickname,t_user.picture,t_topic_archive.*')->where(['t_topic_archive.id'=>$id,'topic_id'=>$tid])->leftjoin('t_user','t_user.id = t_topic_archive.user_id')->asArray()->one();
		return json_encode($data);
	}

/*
topic/index.html 发布话题
*/

	function actionAddTopic(){
		$data=Yii::$app->request->post();
		$model = new TopicContent();
		$model-> topic_id = $data['id'];
		$model-> user_id = $data['userid'];
		$model-> time = time();
		$model-> describe = $data['describe'];
		if($model-> topic_id == 9){
			$model-> niname = $data['nickname'];
			$model-> lastime = time();
			$model-> pics = $data['imgs'];
		}
		if($model->save()){
			//增加匿名话题推送至经纪人的处理 begin
			if($model-> topic_id == 9)
			{
				$model->pushTopic($model->attributes['id']);
			}
			//增加匿名话题推送至经纪人的处理 end
			$res[code] = 1;
			$res['newId'] = $model->attributes['id'];
			if($model-> topic_id == 9){
				$res['pics'] = $model->pics;
			}
			$model2 = Topic::findOne($data['id']);
			$model2 -> lastSubmit = time();
			$model2 -> count += 1;
			$model2->save();
		}else{
			$res[code] = 0;
		}
		return json_encode($res);
	}
	function actionDp(){
		$data=Yii::$app->request->post();
		$model = TopicContent::findOne($data['id']);
		if($data['type'] == 'zan'){
			$oldZan = $model-> zan;
			$model-> zan = $oldZan +1; 
		}else{
			$oldZan = $model-> cai;
			$model-> cai = $oldZan +1;
		}
		
		if($model->save()){
			$res[code] = 1;
			$model2 = Topic::findOne($data['topic']);
			$model2 -> count += 1;
			$model2->save();
		}else{
			$res[code] = 0;
		}
		return json_encode($res);
	}

	function actionPldp(){
		$data=Yii::$app->request->post();
		$model = TopicPl::findOne($data['id']);
		if($data['type'] == 'zan'){
			$oldZan = $model-> zan;
			$model-> zan = $oldZan +1; 
		}
		$model2 = Topic::findOne($model->topic_id);
		Yii::error("actionPldp::model2 is ".print_r($model2,1)."\n");
		if($model->save()){
			$res[code] = 1;
			// $model2 -> count += 1;
			// $model2->save();
		}else{
			$res[code] = 0;
		}
		return json_encode($res);
	}

	function actionPlist(){
		$topic_id = intval($_POST['topic']);
		$page = intval($_POST['page']);
		$archive_id = intval($_POST['id']);

		$rows = (new \yii\db\Query())
		->select(['t_user.picture','t_topic_pl.*'])
		->from('t_topic_pl')
		->leftjoin('t_user','t_user.id = t_topic_pl.user_id')
		->where(['archive_id' => $archive_id,'topic_id' => $topic_id])
		->orderby(['time'=>SORT_DESC])
		->limit(10)
		->offset(($page-1)*10)
		->all();
		$res['code'] = 1;
		$res['data'] = $rows;
		return json_encode($res);
	}

/*
Topic/topicList.html Topic/shuoshuoList.html 回复评论
*/

	function actionAddPlist(){
		$data=Yii::$app->request->post();
		$model = new TopicPl();
		$model-> topic_id = $data['topic'];
		$model-> archive_id = $data['id'];
		$model-> user_id = $data['userid'];
		$model-> time = time();
		$model-> describe = $data['describe'];
		$model->nickname = $data['nickname'];
		if($model->save()){
			$res[code] = 1;
			$res['newId'] = $model->attributes['id'];
			$model2 = Topic::findOne($data['topic']);
			$model2 -> lastSubmit = time();
			$model2 -> count += 1;
			$model2->save();
			$model3 = TopicContent::findOne($data['id']);
			$model3 -> lastime = time();
			$model3->count += 1; 
			$model3->save();
		}else{
			$res[code] = 0;
		}
		return json_encode($res);
	}

	function actionTopicUpload(){
		$base64 = $_POST['base64'];
		$count = count($base64);
		
		for($i=0;$i<$count;$i++){
			$s = base64_decode(str_replace('data:image/jpeg;base64,', '', $base64[$i]['base64']));
			$rand = rand(1000, 9999);
			$res[$i]['picname'] = date("YmdHis",time()) . $rand .'.jpg';
			$res[$i]['status'] = file_put_contents("../web/weixin/Topic/pics/".$res[$i]['picname'], $s);
			$res[$i]['sn'] = $base64[$i]['sn'];
		}
		return json_encode($res);
	}
}
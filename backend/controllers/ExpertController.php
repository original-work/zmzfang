<?php

namespace backend\controllers;

use Yii;
use backend\models\Expert;
use backend\models\ExpertSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * ExpertController implements the CRUD actions for Expert model.
 */
class ExpertController extends BaseController
{
    public $layout = "lte_main";
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }
    public function beforeAction($action){  
        if(Yii::$app->user->isGuest){  
            return $this->goHome();
        }else{
            return parent::beforeAction($action);  
        }
    }
    /**
     * Lists all Expert models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expert model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    

    public function actionUpload()
    {
        $model = new \common\models\Upload();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload(Yii::$app->request->get('id'),'../../frontend/web/images/expertpicture/','expertUpload')) {
                // 文件上传成功
                header('location:http://admin.zmzfang.com/?r=expert/update&id='.Yii::$app->request->get('id'));
                exit;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionUploadBusiness()
    {
        $model = new \common\models\Upload();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload(Yii::$app->request->get('id'),'../../frontend/web/images/expertcard/','expertBussinessUpload')) {
                // 文件上传成功
                header('location:http://admin.zmzfang.com/?r=expert/update&id='.Yii::$app->request->get('id'));
                exit;
            }
        }

        return $this->render('uploadBussiness', ['model' => $model]);
    }
    /**
     * Creates a new Expert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Expert();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Expert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Expert model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Expert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Expert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    function actionSh(){
        $p = Yii::$app->request->post();
        $model = Expert::findOne($p['id']);
        $model->status = $p['shid'];
        if(!empty($p['reasion'])){
            $model->reason = $p['reasion'];
        }
        $model->save();

        $time = date('Y-m-d H:i:s',time());
        $template = array();
        $template['data'] = array();

        $url='http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/MyExpert';
        $toUserInfo=\frontend\models\User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$model->userid])->asArray()->one();
        $content = "点击下方查看详情";
        $first = '您好,'.$toUserInfo['nickname'].'! 您的专家申请';
        yii::error($model->status);
        switch ($model->status) {
            case '1':
                
                $first .='已通过！赶紧去试试吧！';
                $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
                $user->expertflag = 1;
                $user->save();
                if(\frontend\models\Account::find()->where(['userid'=>$model->id])->one()){
                    yii::error('in  if');
                }else{
                    yii::error('in  else');
                    $newAccount = new \frontend\models\Account();
                    $newAccount->userid = $model->id;
                    $newAccount->usertype = 2;
                    $newAccount->openid = $toUserInfo['wxopenid'];
                    $newAccount->historyincome = 0;
                    $newAccount->historyprofit = 0;
                    $newAccount->remainedprofit = 0;
                    $newAccount->drawedprofit =0;
                    $newAccount->usedprofit = 0;
                    $newAccount->lockingprofit =0;
                    $newAccount->createtime = $time;
                    $newAccount->updatetime = $time;
                    $newAccount->save();
                }
                yii::error('in3');
                break;
            case '2':
                $first .='被拒绝了！拒绝原因为'.$model->reason.'！更新资料可重复申请哦。';
                $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
                $user->expertflag = 0;
                $user->save();
                break;
            case '10':
                $first .='被永久拒绝了！拒绝原因为'.$model->reason.'！详情可联系客服。';
                $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
                $user->expertflag = 0;
                $user->save();
                break;
        }
        
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,'芝麻找房',$time,$content];
        $col = [];
        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['wxopenid'];
        $template['url']    = $url;
        yii::error('in4');
        if(!empty($toUserInfo['wxopenid'])){
            $Wechatmodel = new \common\models\Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
        }
        header('Location:http://admin.zmzfang.com/?r=expert/view&id='.$p['id']);
    }

    function actionZd(){
        $p = Yii::$app->request->post();
        $model = Expert::findOne($p['id']);
        $model->priority = $p['priority'];
        if($model->save()){
            header('Location:http://admin.zmzfang.com/?r=expert/view&id='.$p['id']);
        }else{
            echo "error:置顶失败";
        }
    }
}

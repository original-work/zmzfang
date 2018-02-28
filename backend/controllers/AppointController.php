<?php

namespace backend\controllers;

use Yii;
use backend\models\Appoint;
use backend\models\AppointSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppointController implements the CRUD actions for Appoint model.
 */
class AppointController extends BaseController
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
    /**
     * Lists all Appoint models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppointSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Appoint model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $status = \frontend\models\ExpertAppointmentStatus::find()->where(['orderid'=>$id])->orderBy(['id'=>SORT_DESC])->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'status' => $status
        ]);
    }

    /**
     * Creates a new Appoint model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Appoint();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Appoint model.
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
    public function actionSh(){
        $p = Yii::$app->request->post();
        $model = Appoint::findOne($p['id']);
        if($p['shid'] !=1){
            return '失败！';
        }
        $model->status = 6;
        $model->save();
        $time = date('Y-m-d H:i:s',time());
        $connection = Yii::$app->db;


        $sql = sprintf("INSERT INTO t_expert_appointment_status (orderid,orderstatus,statustime,operator)VALUES ($p[id],5,'$time','后台'),($p[id],6,'$time','后台')");
        $command = $connection->createCommand($sql);
        $command->execute();

        $account = \frontend\models\Account::find()->where(['userid'=>$model->expertid])->one();
        $account->historyincome += $model->fee;
        $account->historyprofit += $model->fee*0.9;
        $account->remainedprofit += $model->fee*0.9;
        $account->updatetime = $time;
        $account->save();

        $accountDetail = new  \frontend\models\AccountDetail();
        $accountDetail->userid = $model->expertid;
        $accountDetail->usertype= 2;
        $accountDetail->sumdate= date('Ymd',time());
        $accountDetail->accounttype = '10';
        $accountDetail->servicetype = '1002';
        $accountDetail->originalfee = $model->fee;
        $accountDetail->actualfee = $model->fee*0.9;
        $accountDetail->subject ='线下约见收入';
        $accountDetail->ordertype = 2;
        $accountDetail->orderid = $p['id'];
        $accountDetail->createtime = $time;
        $accountDetail->save();


        $template = array();
        $template['data'] = array();

        $url='http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/MyExpert';


        $expertInfo=\frontend\models\Expert::find()->select('name,userid')->where(['id' =>$model->expertid])->asArray()->one();
        $toUserInfo=\frontend\models\User::find()->select('wxopenid,nickname,phone,wxunionid')->where(['id' =>$expertInfo['userid']])->asArray()->one();
        $content = "点击下方查看详情";
        $first = '您好,'.$expertInfo['name'].'专家! 您的订单已完成，收到款项'.$model->fee.'元。订单号：'.$model->id;

        // switch ($model->status) {
        //     case '1':
        //         $first .='已通过！赶紧去试试吧！';
        //         $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
        //         $user->expertflag = 1;
        //         $user->save();
        //         break;
        //     case '2':
        //         $first .='被拒绝了！拒绝原因为'.$model->reason.'！更新资料可重复申请哦。';
        //         $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
        //         $user->expertflag = 0;
        //         $user->save();
        //         break;
        //     case '10':
        //         $first .='被永久拒绝了！拒绝原因为'.$model->reason.'！详情可联系客服。';
        //         $user = \frontend\models\User::find()->where(['id'=>$model->userid])->one();
        //         $user->expertflag = 0;
        //         $user->save();
        //         break;
        // }
        
        $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
        $columns = ['first','keyword1','keyword2','keyword3'];
        $str = [$first,'芝麻找房',date('Y-m-d',time()),$content];
        $col = [];
        foreach($columns as $key => $value){
            $template['data'][$value]['value'] = $str[$key];
            if(count($col)){
                $template['data'][$value]['color'] = $col[$key];
            }
        }
        $template['touser'] = $toUserInfo['wxopenid'];
        $template['url']    = $url;
        if(!empty($toUserInfo['wxopenid'])){
            $Wechatmodel = new \common\models\Wechat();
            $res = $Wechatmodel -> sendTemplateMessage($template);
        }
        header('Location:http://admin.zmzfang.com/?r=appoint/view&id='.$p['id']);
    }
    /**
     * Deletes an existing Appoint model.
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
     * Finds the Appoint model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appoint the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Appoint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appoints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appoint-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Appoint', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'expertid',
            ['attribute'=>'appointmenttype','label'=>'类型','value' => function ($data) {
                return $data['appointmenttype']==1?"线上":"线下";
            },],
            'questionid',
            ['attribute'=>'status','label'=>'状态','value' => function ($data) {
                if($data['appointmenttype'] == 1){
                    switch ($data['status']) {
                        case '0':
                        return '问题提交（等待支付）';
                        break;
                        case '1':
                        return '客户支付（等待专家答复）';
                        break;
                        case '2':
                        return '专家答复';
                        break;
                        case '3':
                        return '专家拒绝';
                        break;
                        case '4':
                        return '超时未答复';
                        break;
                    }
                }else if($data['appointmenttype'] == 2){
                    switch ($data['status']) {
                        case '0':
                        return '已提交预约申请（等待专家确认）';
                        break;
                        case '1':
                        return '专家确认（等待客户支付）';
                        break;
                        case '2':
                        return '客户支付完成（线下沟通）';
                        break;
                        case '3':
                        return '专家确认流程结束';
                        break;
                        case '4':
                        return '客户确认流程结束';
                        break;
                        case '5':
                        return '平台打款';
                        break;
                        case '6':
                        return '已完成';
                        break;
                        case '7':
                        return '专家拒绝';
                        break;
                        case '8':
                        return '超时未处理';
                        break;
                        case '9':
                        return '其他原因退款';
                        break;
                    }
                }
                
            },],
            // 'appointmentsubject',
            // 'fee',
            // 'ordersubject',
            // 'status',
            // 'createtime',
            ['attribute'=>'updatetime','label'=>'最后响应时间'],
            // 'validflag',
            // 'paytype',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

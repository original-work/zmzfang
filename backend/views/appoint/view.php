<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Appoint */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Appoints', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appoint-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'userid',
            'expertid',
            'appointmenttype',
            'questionid',
            'appointmentsubject',
            'fee',
            'ordersubject',
            'status',
            'createtime',
            'updatetime',
            'validflag',
            'paytype',
        ],
    ]) ?>
    <p>状态：<?php if($model['appointmenttype'] == 1){
                    switch ($model['status']) {
                        case '0':
                        echo '问题提交（等待支付）';
                        break;
                        case '1':
                        echo '客户支付（等待专家答复）';
                        break;
                        case '2':
                        echo '专家答复';
                        break;
                        case '3':
                        echo '专家拒绝';
                        break;
                        case '4':
                        echo '超时未答复';
                        break;
                    }
                }else if($model['appointmenttype'] == 2){
                    switch ($model['status']) {
                        case '0':
                        echo '已提交预约申请（等待专家确认）';
                        break;
                        case '1':
                        echo '专家确认（等待客户支付）';
                        break;
                        case '2':
                        echo '客户支付完成（线下沟通）';
                        break;
                        case '3':
                        echo '专家确认流程结束';
                        break;
                        case '4':
                        echo '客户确认流程结束';
                        break;
                        case '5':
                        echo '平台打款';
                        break;
                        case '6':
                        echo '已完成';
                        break;
                        case '7':
                        echo '专家拒绝';
                        break;
                        case '8':
                        echo '超时未处理';
                        break;
                        case '9':
                        echo '其他原因退款';
                        break;
                    }
                } ?>, </p><p>操作记录：</p><hr>
    <?php
    foreach($status AS $val){
        if($model['appointmenttype'] == 1){
                    switch ($val['orderstatus']) {
                        case '0':
                        $z =  '问题提交（等待支付）';
                        break;
                        case '1':
                        $z =  '客户支付（等待专家答复）';
                        break;
                        case '2':
                        $z =  '专家答复';
                        break;
                        case '3':
                        $z =  '专家拒绝';
                        break;
                        case '4':
                        $z =  '超时未答复';
                        break;
                    }
                }else if($model['appointmenttype'] == 2){
                    switch ($val['orderstatus']) {
                        case '0':
                        $z =  '已提交预约申请（等待专家确认）';
                        break;
                        case '1':
                        $z =  '专家确认（等待客户支付）';
                        break;
                        case '2':
                        $z =  '客户支付完成（线下沟通）';
                        break;
                        case '3':
                        $z =  '专家确认流程结束';
                        break;
                        case '4':
                        $z =  '客户确认流程结束';
                        break;
                        case '5':
                        $z =  '平台打款';
                        break;
                        case '6':
                        $z =  '已完成';
                        break;
                        case '7':
                        $z =  '专家拒绝';
                        break;
                        case '8':
                        $z =  '超时未处理';
                        break;
                        case '9':
                        $z =  '其他原因退款';
                        break;
                    }
                }
        echo '<p>'.$val['statustime'].','.$val['operator'].' 操作了 <span style="color:red">'.$z.'</span><p>';
    }
    echo '<hr>';
    if($model['appointmenttype']==2 && $model->status ==4){ ?>
     
    <form action="index.php?r=appoint/sh" method="POST">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="id" value="<?=$model->id?>" />
        <select name="shid">
            <option value="">请选择</option>
            <option value="1">确认打款</option>
        </select>
        <input type="submit" value="审核" />
    </form>

    <?php } ?>
</div>

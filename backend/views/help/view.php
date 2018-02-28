<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Help */

$this->title = $model->helpid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Helps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->helpid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->helpid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'helpid',
            'publishuserid',
            'publishusertype',
            'requirementtype',
            'region',
            'forhelpsubject',
            'level',
            'forhelpdetail',
            'rewardflag',
            'rewardfee',
            'publishuserpaytime',
            'status',
            'replycnt',
            'adoptedreplyid',
            'adoptedreplyuserid',
            'adopttime',
            'adoptpaytime',
            'updatetime',
            'createtime',
            'validflag',
        ],
    ]) ?>

</div>

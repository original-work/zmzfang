<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Helps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Help'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'helpid',
            'publishuserid',
            'publishusertype',
            'requirementtype',
            'region',
            // 'forhelpsubject',
            // 'level',
            // 'forhelpdetail',
            // 'rewardflag',
            // 'rewardfee',
            // 'publishuserpaytime',
            // 'status',
            // 'replycnt',
            // 'adoptedreplyid',
            // 'adoptedreplyuserid',
            // 'adopttime',
            // 'adoptpaytime',
            // 'updatetime',
            // 'createtime',
            // 'validflag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

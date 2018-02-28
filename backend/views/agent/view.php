<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Agent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'userid' => $model->userid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'userid' => $model->userid], [
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
            'organization',
            'storeinfo',
            'workperiod',
            'position',
            'education',
            'schoolinfo',
            'nativeplace',
            'zmcredit',
            'certificateflag',
            'certificateno',
            'skill',
            'addedservice',
            'pushcity',
            'majordistrict',
            'praisecnt',
            'createtime',
            'updatetime',
            'validflag',
            'businesscard',
        ],
    ]) ?>

</div>

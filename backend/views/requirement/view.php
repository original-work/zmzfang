<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Requirement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requirements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requirement-view">

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
            'publishuserid',
            'publishusertype',
            'requirementtype',
            'region1',
            'region2',
            'region3',
            'districtid',
            'districtname',
            'budget',
            'housetype',
            'storey',
            'buildingtype',
            'detail',
            'acceptagentflag',
            'agentfee',
            'dividefeedescribe',
            'updatetime',
            'createtime',
            'dividerate',
            'expectdividefee',
            'subject',
            'validflag',
        ],
    ]) ?>

</div>

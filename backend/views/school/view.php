<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\Area;

/* @var $this yii\web\View */
/* @var $model backend\models\School */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Schools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '真的删除么?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            // ['attribute' => 'region',
            // 'value'=>
            // function($model){
            //         return Area::getArea('13',$model->region,'00');
            // },
            // ],
            'schoolname',
            'schoolid',
            'districtids',
            'districtnames',
        ],
    ]) ?>

</div>

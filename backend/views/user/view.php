<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'nickname',
            'phone',
            'picture',
            'password',
            'email:email',
            'sex',
            'city',
            'realname',
            'agentflag',
            'identitycard',
            'expertflag',
            'srcflag',
            'totaltimes:datetime',
            'logintime',
            'createtime',
            'wxopenid',
            'wxunionid',
            'tags',
            'validflag',
            'max_requirement',
            'max_supplyment',
            'havemsg',
            'activeregion',
            'homecity',
        ],
    ]) ?>

</div>

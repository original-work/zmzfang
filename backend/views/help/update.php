<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Help */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Help',
]) . $model->helpid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Helps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->helpid, 'url' => ['view', 'id' => $model->helpid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="help-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

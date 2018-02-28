<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cd */

$this->title = 'Update Cd: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

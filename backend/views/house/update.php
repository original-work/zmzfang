<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\House */

$this->title = 'Update House: ' . $model->houseid;
$this->params['breadcrumbs'][] = ['label' => 'Houses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->houseid, 'url' => ['view', 'id' => $model->houseid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="house-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

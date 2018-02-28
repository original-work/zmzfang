<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\helpers\AreaConf */

$this->title = 'Update Area Conf: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Area Confs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="area-conf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

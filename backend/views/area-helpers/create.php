<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\helpers\AreaConf */

$this->title = 'Create Area Conf';
$this->params['breadcrumbs'][] = ['label' => 'Area Confs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-conf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

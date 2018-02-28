<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Expert */

$this->title = 'Create Expert';
$this->params['breadcrumbs'][] = ['label' => 'Experts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

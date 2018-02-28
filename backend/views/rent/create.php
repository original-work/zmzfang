<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rent */

$this->title = 'Create Rent';
$this->params['breadcrumbs'][] = ['label' => 'Rents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

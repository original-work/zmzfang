<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BidSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bid-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'biduserid') ?>

    <?= $form->field($model, 'requirementuserid') ?>

    <?= $form->field($model, 'requirementid') ?>

    <?= $form->field($model, 'bidstatus') ?>

    <?php // echo $form->field($model, 'bidtype') ?>

    <?php // echo $form->field($model, 'biddate') ?>

    <?php // echo $form->field($model, 'houseid') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

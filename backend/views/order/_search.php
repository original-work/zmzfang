<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'out_trade_no') ?>

    <?= $form->field($model, 'attach') ?>

    <?= $form->field($model, 'time_end') ?>

    <?= $form->field($model, 'fee_type') ?>

    <?php // echo $form->field($model, 'total_fee') ?>

    <?php // echo $form->field($model, 'bank_type') ?>

    <?php // echo $form->field($model, 'trade_type') ?>

    <?php // echo $form->field($model, 'openid') ?>

    <?php // echo $form->field($model, 'result_code') ?>

    <?php // echo $form->field($model, 'err_code') ?>

    <?php // echo $form->field($model, 'err_code_des') ?>

    <?php // echo $form->field($model, 'coupon_count') ?>

    <?php // echo $form->field($model, 'sign') ?>

    <?php // echo $form->field($model, 'coupon_fee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

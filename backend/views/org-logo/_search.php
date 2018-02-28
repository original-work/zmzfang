<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgLogoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-logo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'organizationlogoid') ?>

    <?= $form->field($model, 'organizationkey') ?>

    <?= $form->field($model, 'organizationlogo') ?>

    <?= $form->field($model, 'pri') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

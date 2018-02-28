<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'organization') ?>

    <?= $form->field($model, 'storeinfo') ?>

    <?= $form->field($model, 'workperiod') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'schoolinfo') ?>

    <?php // echo $form->field($model, 'nativeplace') ?>

    <?php // echo $form->field($model, 'zmcredit') ?>

    <?php // echo $form->field($model, 'certificateflag') ?>

    <?php // echo $form->field($model, 'certificateno') ?>

    <?php // echo $form->field($model, 'skill') ?>

    <?php // echo $form->field($model, 'addedservice') ?>

    <?php // echo $form->field($model, 'pushcity') ?>

    <?php // echo $form->field($model, 'majordistrict') ?>

    <?php // echo $form->field($model, 'praisecnt') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'updatetime') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <?php // echo $form->field($model, 'businesscard') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

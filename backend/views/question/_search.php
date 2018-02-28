<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'questionsubject') ?>

    <?= $form->field($model, 'questiondetail') ?>

    <?= $form->field($model, 'expertid') ?>

    <?php // echo $form->field($model, 'answer') ?>

    <?php // echo $form->field($model, 'openflag') ?>

    <?php // echo $form->field($model, 'listenedcnt') ?>

    <?php // echo $form->field($model, 'questiondate') ?>

    <?php // echo $form->field($model, 'anserdate') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

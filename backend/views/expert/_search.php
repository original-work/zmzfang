<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpertSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expert-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'organization') ?>

    <?= $form->field($model, 'workperiod') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'activeregion') ?>

    <?php // echo $form->field($model, 'domain') ?>

    <?php // echo $form->field($model, 'businesscard') ?>

    <?php // echo $form->field($model, 'headpicture') ?>

    <?php // echo $form->field($model, 'introduction') ?>

    <?php // echo $form->field($model, 'expertisen') ?>

    <?php // echo $form->field($model, 'onlinecharge') ?>

    <?php // echo $form->field($model, 'offlinetime') ?>

    <?php // echo $form->field($model, 'offlinecharge') ?>

    <?php // echo $form->field($model, 'praisecnt') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

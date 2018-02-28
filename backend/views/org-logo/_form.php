<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgLogo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-logo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organizationlogoid')->textInput() ?>

    <?= $form->field($model, 'organizationkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organizationlogo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pri')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'validflag')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

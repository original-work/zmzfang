<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Bid */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bid-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'biduserid')->textInput() ?>

    <?= $form->field($model, 'requirementuserid')->textInput() ?>

    <?= $form->field($model, 'requirementid')->textInput() ?>

    <?= $form->field($model, 'bidstatus')->textInput() ?>

    <?= $form->field($model, 'bidtype')->textInput() ?>

    <?= $form->field($model, 'biddate')->textInput() ?>

    <?= $form->field($model, 'houseid')->textInput() ?>

    <?= $form->field($model, 'validflag')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

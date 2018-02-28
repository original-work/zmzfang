<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Rent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'publishuserid')->textInput() ?>

    <?= $form->field($model, 'publishusertype')->textInput() ?>

    <?= $form->field($model, 'requirementtype')->textInput() ?>

    <?= $form->field($model, 'region1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'region2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'region3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'regions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'districtid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'districtname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'housetype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'storey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buildingtype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'validflag')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

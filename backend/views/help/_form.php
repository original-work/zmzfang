<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Help */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'publishuserid')->textInput() ?>

    <?= $form->field($model, 'publishusertype')->textInput() ?>

    <?= $form->field($model, 'requirementtype')->textInput() ?>

    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forhelpsubject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'forhelpdetail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rewardflag')->textInput() ?>

    <?= $form->field($model, 'rewardfee')->textInput() ?>

    <?= $form->field($model, 'publishuserpaytime')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'replycnt')->textInput() ?>

    <?= $form->field($model, 'adoptedreplyid')->textInput() ?>

    <?= $form->field($model, 'adoptedreplyuserid')->textInput() ?>

    <?= $form->field($model, 'adopttime')->textInput() ?>

    <?= $form->field($model, 'adoptpaytime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'validflag')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

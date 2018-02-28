<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'picture')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agentflag')->textInput() ?>

    <?= $form->field($model, 'identitycard')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expertflag')->textInput() ?>

    <?= $form->field($model, 'srcflag')->textInput() ?>

    <?= $form->field($model, 'totaltimes')->textInput() ?>

    <?= $form->field($model, 'logintime')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'wxopenid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wxunionid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'validflag')->textInput() ?>

    <?= $form->field($model, 'max_requirement')->textInput() ?>

    <?= $form->field($model, 'max_supplyment')->textInput() ?>

    <?= $form->field($model, 'havemsg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activeregion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'homecity')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

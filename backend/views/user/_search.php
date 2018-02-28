<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'picture') ?>

    <?= $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'realname') ?>

    <?php // echo $form->field($model, 'agentflag') ?>

    <?php // echo $form->field($model, 'identitycard') ?>

    <?php // echo $form->field($model, 'expertflag') ?>

    <?php // echo $form->field($model, 'srcflag') ?>

    <?php // echo $form->field($model, 'totaltimes') ?>

    <?php // echo $form->field($model, 'logintime') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'wxopenid') ?>

    <?php // echo $form->field($model, 'wxunionid') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <?php // echo $form->field($model, 'max_requirement') ?>

    <?php // echo $form->field($model, 'max_supplyment') ?>

    <?php // echo $form->field($model, 'havemsg') ?>

    <?php // echo $form->field($model, 'activeregion') ?>

    <?php // echo $form->field($model, 'homecity') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RequirementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requirement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'publishuserid') ?>

    <?= $form->field($model, 'publishusertype') ?>

    <?= $form->field($model, 'requirementtype') ?>

    <?= $form->field($model, 'region1') ?>

    <?php // echo $form->field($model, 'region2') ?>

    <?php // echo $form->field($model, 'region3') ?>

    <?php // echo $form->field($model, 'districtid') ?>

    <?php // echo $form->field($model, 'districtname') ?>

    <?php // echo $form->field($model, 'budget') ?>

    <?php // echo $form->field($model, 'housetype') ?>

    <?php // echo $form->field($model, 'storey') ?>

    <?php // echo $form->field($model, 'buildingtype') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'acceptagentflag') ?>

    <?php // echo $form->field($model, 'agentfee') ?>

    <?php // echo $form->field($model, 'dividefeedescribe') ?>

    <?php // echo $form->field($model, 'updatetime') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <?php // echo $form->field($model, 'dividerate') ?>

    <?php // echo $form->field($model, 'expectdividefee') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

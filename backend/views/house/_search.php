<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HouseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'houseid') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'districtid') ?>

    <?= $form->field($model, 'districtname') ?>

    <?= $form->field($model, 'housenumber') ?>

    <?php // echo $form->field($model, 'roomnumber') ?>

    <?php // echo $form->field($model, 'buildingarea') ?>

    <?php // echo $form->field($model, 'expectsaleprice') ?>

    <?php // echo $form->field($model, 'storey') ?>

    <?php // echo $form->field($model, 'totalstorey') ?>

    <?php // echo $form->field($model, 'roomcnt') ?>

    <?php // echo $form->field($model, 'hallcnt') ?>

    <?php // echo $form->field($model, 'bathroomcnt') ?>

    <?php // echo $form->field($model, 'houseage') ?>

    <?php // echo $form->field($model, 'buildingtype') ?>

    <?php // echo $form->field($model, 'decorationtype') ?>

    <?php // echo $form->field($model, 'orientation') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'schooldistrictflag') ?>

    <?php // echo $form->field($model, 'metroflag') ?>

    <?php // echo $form->field($model, 'owneronlyflag') ?>

    <?php // echo $form->field($model, 'publishdate') ?>

    <?php // echo $form->field($model, 'overfiveonlyflag') ?>

    <?php // echo $form->field($model, 'validflag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

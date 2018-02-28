<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Help */

$this->title = Yii::t('app', 'Create Help');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Helps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

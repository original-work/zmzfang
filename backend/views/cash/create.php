<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cash */

$this->title = 'Create Cash';
$this->params['breadcrumbs'][] = ['label' => 'Cashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

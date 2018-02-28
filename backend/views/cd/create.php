<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cd */

$this->title = 'Create Cd';
$this->params['breadcrumbs'][] = ['label' => 'Cds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

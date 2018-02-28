<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Topic */

$this->title = 'Create Topic';
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

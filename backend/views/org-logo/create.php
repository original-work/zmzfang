<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OrgLogo */

$this->title = 'Create Org Logo';
$this->params['breadcrumbs'][] = ['label' => 'Org Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-logo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

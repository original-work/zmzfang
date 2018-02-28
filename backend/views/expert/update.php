<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Expert */

$this->title = 'Update Expert: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Experts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expert-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><img src="<?=$model->headpicture?>" /></p>
    <p><a href="./?r=expert/upload&id=<?=$model->id?>">上传头像</a></p>
    <p><img src="<?=$model->businesscard?>" /></p>
    <p><a href="./?r=expert/upload-business&id=<?=$model->id?>">上传名片</a></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

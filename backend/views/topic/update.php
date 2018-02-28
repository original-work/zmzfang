<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Topic */

$this->title = 'Update Topic: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><img src="http://www.zmzfang.com/assets/topic/<?=$model->picture?>" /></p>
    <p><a href="./?r=topic/upload&id=<?=$model->id?>">上传图片(建议3：1)</a></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Question */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'duration' => $model->duration], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'duration' => $model->duration], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'userid',
            'questionsubject',
            'questiondetail',
            'expertid',
            'answer',
            'openflag',
            'listenedcnt',
            'questiondate',
            'anserdate',
            'duration',
            'priority',
        ],
    ]) ?>
    <p>置顶等级：<?=$model->priority?></p>
    <form action="index.php?r=expert/zd" method="POST">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="id" value="<?=$model->id?>" />
        <input type="number" name="priority" />
        <input type="submit" value="置顶" />
    </form>
</div>

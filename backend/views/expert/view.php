<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Expert */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Experts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'name',
            'organization',
            'workperiod',
            'position',
            'email:email',
            'activeregion',
            'domain',
            ['label'=>'名片','value'=>'<img src="'.$model->businesscard.'" />','format'=>'html'],
            'introduction',
            'expertisen',
            'onlinecharge',
            'offlinetime',
            'offlinecharge',
            'praisecnt',
            'status',
            ['label'=>'头像','value'=>'<img src="'.$model->headpicture.'" />','format'=>'html'],
        ],
    ]) ?>
    <p>状态：<?php switch($model->status){case '1': echo "通过"; break;case '2': echo "拒绝";break;case '0':echo "待处理";break;case "10":echo "拉黑";break;default:echo "待处理";}?>, 最后一次拒绝理由：<?=$model->reason?></p>
    <form action="index.php?r=expert/sh" method="POST">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="id" value="<?=$model->id?>" />
        <select name="shid">
            <option value="1">通过</option>
            <option value="2">拒绝</option>
            <option value="10">拉黑</option>
        </select>
        <textarea name="reasion" placeholder="如果拒绝填写理由"></textarea>
        <input type="submit" value="审核" />
    </form>
    <p>置顶等级：<?=$model->priority?></p>
    <form action="index.php?r=expert/zd" method="POST">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="id" value="<?=$model->id?>" />
        <input type="number" name="priority" />
        <input type="submit" value="置顶" />
    </form>
</div>

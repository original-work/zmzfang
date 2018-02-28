<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\House */

$this->title = $model->houseid;
$this->params['breadcrumbs'][] = ['label' => 'Houses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->houseid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->houseid], [
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
            'houseid',
            'userid',
            'districtid',
            'districtname',
            'housenumber',
            'roomnumber',
            'buildingarea',
            'expectsaleprice',
            'storey',
            'totalstorey',
            'roomcnt',
            'hallcnt',
            'bathroomcnt',
            'houseage',
            'buildingtype',
            'decorationtype',
            'orientation',
            'detail',
            'schooldistrictflag',
            'metroflag',
            'owneronlyflag',
            'publishdate',
            'overfiveonlyflag',
            'validflag',
            ['label'=>'图片','value'=>$model->pics($model->houseid),'format'=>'html'],
        ]
    ]) ?>

</div>

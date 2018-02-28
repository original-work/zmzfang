<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrgLogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Org Logos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-logo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Org Logo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'organizationlogoid',
            [
            'attribute' => 'organizationlogo',
                'label'=>'头像',
                'format'=>'raw',
                'value'=>function($m){
                    return Html::img($m->organizationlogo,
                                ['class' => 'img-circle',
                                'width' => 30]
                    );
                }
            ],
            'organizationkey',

            'pri',
            // 'remark',
            // 'detail',
            // 'createtime',
            // 'validflag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

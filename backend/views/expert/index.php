<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExpertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Experts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Expert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'name',
            'organization',
            'priority',
            // 'position',
            // 'email:email',
            // 'activeregion',
            // 'domain',
            // 'businesscard',
            // 'headpicture',
            // 'introduction',
            // 'expertisen',
            // 'onlinecharge',
            // 'offlinetime',
            // 'offlinecharge',
            // 'praisecnt',
            // 'status',
            ['attribute'=>'审核状态','value' => function ($data) {

                switch($data->status){case '1': $count = "通过"; break;case '2': $count = "拒绝";break;case '0':$count = "待处理";break;case "10":$count = "拉黑";break;default:$count="待处理";}
                return $count;
            },'format'=>'raw'],
            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

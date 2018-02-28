<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Houses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create House', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'houseid',
            'userid',
            'districtid',
            'districtname',
            'housenumber',
            ['attribute'=>'nickname','label'=>'房源图','value' => function ($data) {
                $user = \backend\models\Pic::find()->where(["houseid"=>$data->houseid])->count();
                return $user;
            },],
            // 'roomnumber',
            // 'buildingarea',
            // 'expectsaleprice',
            // 'storey',
            // 'totalstorey',
            // 'roomcnt',
            // 'hallcnt',
            // 'bathroomcnt',
            // 'houseage',
            // 'buildingtype',
            // 'decorationtype',
            // 'orientation',
            // 'detail',
            // 'schooldistrictflag',
            // 'metroflag',
            // 'owneronlyflag',
            // 'publishdate',
            // 'overfiveonlyflag',
            // 'validflag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

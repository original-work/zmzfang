<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bids';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bid-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        //echo Html::a('Create Bid', ['create'], ['class' => 'btn btn-success']) 
        ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'id','label'=>'id'],
            ['attribute'=>'biduserid','label'=>'投标人id'],
            ['attribute'=>'requirementuserid','label'=>'需求发布人id'],
            ['attribute'=>'phone','label'=>'需求人手机','value' => function ($data) {
                $user = \frontend\models\User::findOne(["id"=>$data->requirementuserid]);
                return $user['phone'];
            },],
            ['attribute'=>'requirementid','label'=>'需求id'],
            ['attribute'=>'bidstatus','label'=>'投标状态，取值：1--已投标，2--已接受,3--已拒绝'],
            ['attribute'=>'bidtype','label'=>'投标类型：0--房源所有人投标，1--系统推荐'],
            ['attribute'=>'biddate','label'=>'时间'],
            ['attribute'=>'houseid','label'=>'房源id'],
            ['attribute'=>'validflag','label'=>'是否有效'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

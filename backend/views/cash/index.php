<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cashes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cash', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'usertype',
            'amount',
            'createtime',
            'updatetime',
            ['attribute'=>'status','label'=>'提现类型','value'=>function ($data) {
                switch ($data->status) {
                    case 1:
                        return '申请中';
                    case 4:
                        return '完成';
                }
            },],

            ['attribute'=>'validflag','label'=>'是否有效','value'=>function ($data) {
                switch ($data->validflag) {
                    case 1:
                        return '有效';
                    case 0:
                        return '无效';
                }
            },],

            ['class' => 'yii\grid\ActionColumn'],
            ['label'=>'提现','format'=>'raw','value'=>function ($data) {
                if ($data->validflag && $data->status!=4) {
                    return '<a href="javascript:if(confirm(\'请认真核对进行操作，确定要操作提现吗？\'))location=\'./?r=wechat/tixian&id='.$data->id.'\'">提现</a>';
                }
            },],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

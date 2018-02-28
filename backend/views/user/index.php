<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'picture',
                'label'=>'头像',
                'format'=>'raw',
                'value'=>function($m){
                    return Html::img($m->picture,
                                ['class' => 'img-circle',
                                'width' => 30]
                    );
                }
            ],
            'id',
            'nickname',
            'phone',
            // 'password',
            // 'email:email',
            // 'sex',
            'city',
            // 'realname',
            [   'attribute' => 'agentflag',
               'value' => function ($model, $key, $index, $column) {
                        return Html::a($model->agentflag?'查看':'', 
                            ['agent/index', 'AgentSearch[userid]' => $key]);
                },
               'format' => 'raw',
            ],
            [   'attribute' => 'expertflag',
               'value' => function ($model, $key, $index, $column) {
                        return Html::a($model->expertflag?'查看':'', 
                            ['expert/index', 'ExpertSearch[userid]' => $key]);
                },
               'format' => 'raw',
            ],
            // 'identitycard',
            // 'expertflag',
            // 'srcflag',
            // 'totaltimes:datetime',
            // 'logintime',
            // 'createtime',
            // 'wxopenid',
            // 'wxunionid',
            // 'tags',
            // 'validflag',
            // 'max_requirement',
            // 'max_supplyment',
            // 'havemsg',
            // 'activeregion',
            // 'homecity',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

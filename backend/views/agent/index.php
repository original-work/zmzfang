<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Agent', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'organization',
            // 'storeinfo',
            'workperiod',
            'position',
            [
            'attribute' => 'education',
                'label'=>'学历',
                'value'=>function($m){
                    return Yii::$app->params['edu'][$m->education];
                }
            ],
             [
              'label'=>'经纪人公司Logo',
              'attribute'=>'organizationlogo',
              // 'value'=>'logo.organizationlogo'
              'format'=>'raw',
                'value'=>function($m){
                    // var_dump($m->logo->organizationlogo);
                    return Html::img($m->logo->organizationlogo,
                                ['class' => 'img-circle',
                                'width' => 30]
                    );
                }
            ],
            // 'schoolinfo',
            // 'nativeplace',
            // 'zmcredit',
            // 'certificateflag',
            // 'certificateno',
            // 'skill',
            // 'addedservice',
            // 'pushcity',
            // 'majordistrict',
            // 'praisecnt',
            // 'createtime',
            // 'updatetime',
            // 'validflag',
            // 'businesscard',
            'datacompleterate',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

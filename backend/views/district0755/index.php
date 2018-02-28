<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\AreaConf;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Districts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create District', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'districtid',
			'districtname',
			'address',
			// 'latitude',
			// 'longitude',
			// 'completedtime',
			['attribute' => 'region',
			'value'=>
			function($model){
				return \common\helpers\AreaConf::php2json('深圳市')['region'][$model->region];
			},
			],
			['attribute' => 'plate',
			'value'=>
			function($model){
				return ( \common\helpers\AreaConf::php2json('深圳市')['block'][$model->region]['075513'.$model->region.$model->plate]['plate']);
			},
			],

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
<?php Pjax::end(); ?></div>

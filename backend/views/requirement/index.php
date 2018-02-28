<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequirementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requirements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requirement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Requirement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'publishuserid',
             [
              'label'=>'发布人',
              'attribute'=>'nickname',
              'value'=>'user.nickname'
            ],
            'publishusertype',
            'requirementtype',
            ['attribute'=>'count','label'=>'刷新','value' => function ($data) {
                
                return "<a href='javascript:ajax_to_server(".$data->id.")' >刷新</a>";
            },'format'=>'raw'],
            ['attribute'=>'count','label'=>'投标数','value' => function ($data) {
                $count = \frontend\models\Bid::find()->where(["requirementid"=>$data->id])->count();
                return $count;
            },],
            ['attribute'=>'url','label'=>'前台查看','value' => function ($data) {
                $count = "<a href='http://www.zmzfang.com/weixin/HomePage/RequirementDetail.html?requirementId=".$data->id."&userId=".$data->publishuserid."' target='_blank'>查看</a>";
;
                return $count;
            },'format'=>'raw'],
            // 'region1',
            // 'region2',
            // 'region3',
            // 'districtid',
            // 'districtname',
            // 'budget',
            // 'housetype',
            // 'storey',
            // 'buildingtype',
            // 'detail',
            // 'acceptagentflag',
            // 'agentfee',
            // 'dividefeedescribe',
            // 'updatetime',
            // 'createtime',
            // 'dividerate',
            // 'expectdividefee',
            // 'subject',
            // 'validflag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php $this->beginBlock('js'); ?>
    <script type="text/javascript">
        function ajax_to_server(id){
            $.get('./?r=requirement/fresh&id='+id, function(data) {
                data = JSON.parse(data);
                if(data.rscode == 0){
                    alert('需求id'+data.id+' - 刷新成功');
                }else{
                    alert('需求id'+id+' - 刷新失败');
                }
            });
        }
    </script>
<?php $this->endBlock('js'); ?>
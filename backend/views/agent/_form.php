<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Agent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'organizationlogoid')->textInput(['maxlength' => true])->label('LogoId(<button type="button" data-toggle="modal" data-target="#myModal" onclick="javascript:$(\'#findLogo\').val(\''.$model->organization.'\');ajax_to_server(\''.$model->organization.'\')">选取logo</button>)') ?>

    <?= $form->field($model, 'storeinfo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workperiod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schoolinfo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nativeplace')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zmcredit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'certificateflag')->textInput() ?>

    <?= $form->field($model, 'certificateno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skill')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addedservice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pushcity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'majordistrict')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'praisecnt')->textInput() ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <?= $form->field($model, 'updatetime')->textInput() ?>

    <?= $form->field($model, 'validflag')->textInput() ?>

    <?= $form->field($model, 'businesscard')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="text" id="findLogo" oninput="javascript:ajax_to_server(this.value)" />
            <ul id="list"></ul>
          </div>
        </div>
      </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('js') ?>
<script type="text/javascript">
    function ajax_to_server(val){
        if(val.trim()){
            $.get('./?r=org-logo/search-logo&k='+val,function(data){
                data = JSON.parse(data);
                if(data.length>0){
                    var html = '';
                    for(i in data){
                        html += '<li><img src="'+data[i].organizationlogo+'" />'+data[i].organizationkey+'&nbsp;&nbsp;&nbsp;<a href="javascript:$(\'#agent-organizationlogoid\').val('+data[i].organizationlogoid+');$(\'#myModal\').modal(\'hide\')">选取</a></li>';
                    }
                    $('#list').html(html);
                }
            })
        }
        
    }
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\House */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'houseid')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput()->label('发布人id') ?>

    <?= $form->field($model, 'districtname')->textInput(['maxlength' => true])->label('小区名') ?>
            <input value="修改小区" data-toggle="modal" data-target="#myModal" type="button">
            <?= $form->field($model, 'districtid')->textInput(['readonly'=>'readonly'],['maxlength' => true])->label('小区id') ?>

    <?= $form->field($model, 'housenumber')->textInput()->label('门牌号') ?>

    <?= $form->field($model, 'roomnumber')->textInput()->label('室号') ?>

    <?= $form->field($model, 'buildingarea')->textInput()->label('建筑面积，单位平米') ?>

    <?= $form->field($model, 'expectsaleprice')->textInput()->label('期望价格') ?>

    <?= $form->field($model, 'storey')->textInput()->label('楼层') ?>

    <?= $form->field($model, 'totalstorey')->textInput()->label('总楼层') ?>

    <?= $form->field($model, 'roomcnt')->textInput()->label('室数') ?>

    <?= $form->field($model, 'hallcnt')->textInput()->label('厅') ?>

    <?= $form->field($model, 'bathroomcnt')->textInput()->label('卫') ?>

    <?= $form->field($model, 'houseage')->textInput()->label('房龄，填写1980 - 2016 4位数') ?>

    <?= $form->field($model, 'buildingtype')->dropDownList(['住宅'=>'住宅','商住'=>'商住','办公'=>'办公','商铺'=>'商铺']) ?>

    <?= $form->field($model, 'decorationtype')->dropDownList(['毛坯'=>'毛坯','简装'=>'简装','中装'=>'中装','精装'=>'精装','豪装'=>'豪装']) ?>

    <?= $form->field($model, 'orientation')->dropDownList(['东'=>'东','南'=>'南','西'=>'西','北'=>'北','东南'=>'东南','西南'=>'西南','东北'=>'东北','西北'=>'西北']) ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schooldistrictflag')->textInput() ?>

    <?= $form->field($model, 'metroflag')->textInput() ?>

    <?= $form->field($model, 'owneronlyflag')->textInput() ?>

    <?= $form->field($model, 'publishdate')->textInput(['placeholder'=>date
    ("Y-m-d H:i:s", time())]) ?>

    <?= $form->field($model, 'overfiveonlyflag')->textInput() ?>

    <?= $form->field($model, 'validflag')->textInput(['placeholder'=>'1']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">搜索小区</h4>
          </div>
          <div class="modal-body">
            <input type="text" id="keywords" placeholder="请输入小区名称" oninput="getDistrictMatch()">
            <div id="district"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="/assets/js/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('form input').each(function(index){
                if(!$(this).val()){
                    $(this).val($(this).attr('placeholder'));
                }
            })
    });
    function getDistrictMatch(){
        var keys = $("#keywords").val();
        // console.log(keys); 
        jQuery.ajax("http://www.zmzfang.com/index.php?r=area/get-district-match", {
            data: '{"keys":"'+keys+'"}',
            dataType: 'json',
            type: 'post',
            timeout: 10000,
            success: function(data) {
                console.log('ajax_get_district_match suc .data.'+JSON.stringify(data));
                getDistrictMathSuccess(data);
            },
            error: function(xhr, type, errorThrown) {
                //getDistrictMathFailed(errorThrown);
                                
                toastMSG = '网络异常，处理失败，请重试！';
            }
        });
    }
    function getDistrictMathSuccess(data){
                var district=$('#district');
                var str = '';
                for(var i in data)
                {
                    var datas = fillDistrictList(data[i]);
                    // console.log('\n districtid:'+districtid);
                    str += datas;
                }
                district.html(str);
    }

    function fillDistrictList(data){
                    var did = data.districtid;
                    var dname = data.districtname;
                    var address = data.address;

                    var liContent = '<li onclick="addTip('+did+',\''+dname+'\')" >';
                    liContent += dname;
                    liContent += '(';
                    liContent += address;
                    liContent += ')</li>';
                    
                    return liContent;
    }
    function addTip(id,name) {
            $('#house-districtid').val(id);
            $('#house-districtname').val(name);
            $('#myModal').modal('hide')
        }
</script>

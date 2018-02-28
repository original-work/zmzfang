<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Area;
/* @var $this yii\web\View */
/* @var $model backend\models\Requirement */
/* @var $form yii\widgets\ActiveForm */

$value = $model->attributes;
?>

<div class="requirement-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['readonly'=>'readonly'])->label('购房需求id 默认') ?>

    <?= $form->field($model, 'publishuserid')->textInput()->label('发布人id') ?>

    <?= $form->field($model, 'publishusertype')->textInput(['placeholder'=>0])->label('发布人类型，0表示普通用户，1表示经纪人') ?>

    <?= $form->field($model, 'requirementtype')->dropDownList(['1'=>'区域','2'=>'小区'],['style'=>'width:120px'])->label('求购类型，1表示按区域，2表示按小区') ?>
    <div id="type1">
        <?= $form->field($model, 'region1')->textInput(['placeholder'=>'13'],['maxlength' => true])->label('区域名称1，取值为：地铁，学区，板块;') ?>
        <?= $form->field($model, 'region2')->dropDownList(Area::returnSchoolArea(), ['prompt'=>'请选择','style'=>'width:120px'],['maxlength' => true]) ?>
            <div class="form-group">
                <label class="control-label" for="requirement-region3">区域名称2，取值说明：区域名称1为地铁时，取值为地铁线路名称；区域名称1为学区时，取值为地区名称；区域名称1为板块时，取值为区县名称；</label>
                <select class="form-control" name="Requirement[region3]" id="requirement-region3">
                    <option>请先选择区域</option>
                </select>
            </div>
    </div>
    <div id="type2">
            <?= $form->field($model, 'districtname')->textInput(['maxlength' => true])->label('小区名') ?>
            <input value="添加小区" data-toggle="modal" data-target="#myModal" type="button">
            <?= $form->field($model, 'districtid')->textInput(['readonly'=>'readonly'],['maxlength' => true])->label('小区id') ?>
    </div>
    

    <?= $form->field($model, 'budget')->dropDownList(['0-99'=>'100万以内','100-149'=>'100万到150万','150-199'=>'150万到200万','200-299'=>'200万到300万','300-399'=>'300万到400万','400-599'=>'400万到600万','600-799'=>'600万到800万','800-999'=>'800万到1000万','1000-90000'=>'1000万以上'],['maxlength' => true])->label('预算总价，单位万元') ?>

    <?= $form->field($model, 'housetype')->textInput(['maxlength' => true])->label('户型，取值1,2,3,4,   5代表>=5等；') ?>

    <?= $form->field($model, 'storey')->dropDownList(['0-300'=>'0-300','1-3'=>'1-3','4-6'=>'4-6','7-10'=>'7-10','11-15'=>'11-15','16-22'=>'16-22','22-30'=>'22-30'],['maxlength' => true])->label('楼层，取值为：不限，1-3楼，4-6楼，7-10楼，11-15楼，16-22楼，22-30楼，其他') ?>

    <?= $form->field($model, 'buildingtype')->dropDownList(['住宅'=>'住宅','商住'=>'商住','办公'=>'办公','商铺'=>'商铺'],['maxlength' => true])->label('类型，取值描述：住宅，商住，办公，商铺') ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true])->label('具体描述') ?>

    <?= $form->field($model, 'acceptagentflag')->textInput(['placeholder'=>0])->label('接收经纪人投标标识，0代表不接收，1代表接收') ?>

    <?= $form->field($model, 'agentfee')->textInput(['placeholder'=>0])->label('原因支付佣金，如25000 单位元；') ?>

    <?= $form->field($model, 'dividefeedescribe')->textInput(['readonly'=>'readonly'],['maxlength' => true])->label('我方向客户分拥描述，如“总房款*2%”,弃用 勿填') ?>

    <?= $form->field($model, 'updatetime')->textInput(['placeholder'=>date
    ("Y-m-d H:i:s", time())])->label('最近一次更新时间') ?>

    <?= $form->field($model, 'createtime')->textInput(['placeholder'=>date
    ("Y-m-d H:i:s", time())])->label('创建时间') ?>

    <?= $form->field($model, 'dividerate')->textInput(['maxlength' => true])->label('分佣比例') ?>

    <?= $form->field($model, 'expectdividefee')->textInput(['readonly'=>'readonly'])->label('预期佣金 弃用') ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label('标题，自动生成滴') ?>

    <?= $form->field($model, 'validflag')->textInput(['placeholder'=>1],['maxlength' => true])->label('判断是否删除 0删') ?>
    <input type="button" onclick="getSubject()" value="获取subject" />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=>'return check()']) ?>
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
<script src="http://www.zmzfang.com/weixin/js/area.js"></script>
<script src="http://admin.zmzfang.com/common.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('form input').each(function(index){
            if(!$(this).val()){
                $(this).val($(this).attr('placeholder'));
            }
        })
        <?php if($value['region2']) :?>
        var Ilist = getArea('13','<?=$value['region2']?>','00','list');
        $('#type1').show();
        $('#type2').hide();
        initOption(Ilist);
        <?php endif; ?>
        <?php if($value['districtid']) :?>
        $('#type2').show();
        $('#type1').hide();
        <?php endif; ?>

        <?php if(!$value['id']) :?>
        $('#type1').show();
        $('#type2').hide();
        <?php endif; ?>

        <?php if($value['requirementtype']) :?>
        initRequirType(<?=$value['requirementtype']?>);
        <?php endif ?>
       
    });  
    $('#requirement-region2').on("change",function(){   
            var Slist = getArea('13',$(this).val(),'00','list');
            initOption(Slist);
            // console.log(Slist);
    });
    function getSubject(){
        if(parseInt( $("#requirement-region2").val() ) && parseInt( $("#requirement-region3").val() ) ){
            $("#requirement-subject").val($("#requirement-region2").find('option:selected').text() + $("#requirement-region3").find('option:selected').text() );
        }else{
            $("#requirement-subject").val($("#requirement-districtname").val() );
        }
    }
    function check(){
        if( (parseInt($("#requirement-region2").val()) && parseInt($("#requirement-region3").val()) ) || parseInt( $("#requirement-districtid").val())){
            getSubject();
            if( ( parseInt($("#requirement-agentfee").val()) && parseInt($("#requirement-acceptagentflag").val()) ) || (!parseInt($("#requirement-agentfee").val()) ) && (!parseInt($("#requirement-acceptagentflag").val()))){
                // alert($("#requirement-agentfee").val());
                // alert($("#requirement-acceptagentflag").val());
                
            }else{
                alert("agentfee 和 acceptagentflag 冲突，检查 佣金 和 接受经纪人投标");
                return false;
            }
            
        }else{
            alert("subject 无法生成!请检查");
            return false;
        }
        if (parseInt($("#requirement-agentfee").val()) && parseInt($("#requirement-acceptagentflag").val())) {
            if($("#requirement-publishusertype").val() == 1){
                    if( parseInt($("#requirement-dividerate").val()) ){
                       
                    }else{
                        alert('发布人为经纪人时  必须填写分佣比例');
                        return false;
                    }
                }else{
                    if( parseInt($("#requirement-dividerate").val()) ){
                        alert('发布人不为经纪人时  勿必须填写分佣比例');
                        return false;
                        
                    }else{
                        
                    }
                }
        }
        
        if(parseInt($('#requirement-publishuserid').val())){
            return true;
        }else{
            alert('请输入发布人id')
            return false;
        }
    }
    function initOption(Slist){
        var option ='<option value="00">请选择板块</option>';
            var s = '';
            for(i in  Slist){
                if (Slist[i]['value'].substr(2,2) =='<?=$value['region2']?>' && Slist[i]['value'].substr(4,2) =='<?=$value['region3']?>') {
                    s = "selected = 'selected'";
                }else{
                    s = '';
                }
                option += "<option "+ s +" value='";
                option += Slist[i]['value'].substr(4,2);
                option += "'>" + Slist[i]['text'] +"</option>";
            }
            $("#requirement-region3").html(option);
    }
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
            $('#requirement-districtid').val(id);
            $('#requirement-districtname').val(name);
            $('#myModal').modal('hide')
        }
        //init
    
    $("#requirement-requirementtype").change(function(){
        initRequirType($(this).val());
    });
    function initRequirType(value){
        if ( value == 1){
            $('#type1').show();
            $('#requirement-region1').val(13);
            $('#requirement-districtid').val('');
            $('#requirement-districtname').val('');
            $('#type2').hide();
        }else{
            $('#type2').show();
            $('#requirement-region1').val('');
            $('#requirement-region2').val('');
            $('#requirement-region3').val('');
            $('#type1').hide();
        }
    }
    </script>


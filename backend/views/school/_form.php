<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Area;
/* @var $this yii\web\View */
/* @var $model backend\models\School */
/* @var $form yii\widgets\ActiveForm */
$value = $model->attributes;
?>

<div class="school-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'city')->textInput(['readonly'=>'readonly']) ?>
            
    <?= $form->field($model, 'region')->dropDownList(Area::returnSchoolArea(), ['prompt'=>'请选择','style'=>'width:120px'],['maxlength' => true]) ?>
    <div class="form-group">
                        <label class="control-label" for="metro-region-add">板块</label>
                        <select class="form-control" name="School[plate]" id="metro-region-add">
                            <option>请先选择区域</option>
                        </select>
    </div>
    <?= $form->field($model, 'schoolname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schoolid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'districtids')->textInput(['readonly'=>'readonly']) ?>
    <?= $form->field($model, 'districtnames')->textInput(['readonly'=>'readonly'],['maxlength' => true]) ?>
    <div class="form-group">
    <div id="tip" style="background:#ccc;">
    </div>
        
    </div>
    <input value="添加小区" data-toggle="modal" data-target="#myModal" type="button">
    <input value="重置" type="button" onclick="$('#school-schoolid').val('<?= $model['schoolid']?>')">
    </div>
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
    InitTips();
    <?php if($value['region']) :?>
        var Ilist = getArea('13','<?=($value['region'])?>','00','list');
        initOption(Ilist);
        <?php endif; ?>
	$("#school-region").change(function(){
        var Slist = getArea('13',$(this).val(),'00','list');
            initOption(Slist);
            console.log(Slist);
		$.get("http://admin.zmzfang.com/?r=ajax/num",{ val: $(this).val() }, function(data){
				data = parseInt(data);
				var res = data+1;
				res = res<10 ? "0"+res : res;
		  		$("#school-schoolid").val(res);
		});
	});
    function initOption(Slist){
        var option ='<option value="">请选择板块</option>';
            var s = '';
            for(i in  Slist){
                if (Slist[i]['value'] =='<?=$value['plate']?>') {
                    s = "selected = 'selected'";
                }else{
                    s = '';
                }
                option += "<option "+ s +" value='";
                option += Slist[i]['value'];
                option += "'>" + Slist[i]['text'] +"</option>";
            }
            $("#metro-region-add").html(option);
    }
    function addTip(id,name) {
            var tipcon = '<span data-id = "'+id+'">' +name +
                '<span class="glyphicon glyphicon-remove del" onclick="$(this).parent().remove();initCid();"></span>' +
                '</span>&nbsp;&nbsp;&nbsp;';
            $('#tip').append(tipcon);
            initCid();

        }
    function InitTips(){
        if($("#school-districtids").val() == ''){
            return false;
        }
        var ids = $("#school-districtids").val().split(",");
        var names = $("#school-districtnames").val().split(",");
        // console.log(names.length);
            for (i in ids){
                var id = ids[i];
                var name = names[i];
                addTip(id,name);
            }
    }
    function initCid(){
        var ids = '';
        var names = '';
        var indexs = '';
        $("#tip > span").each(function(index){

            var name = $(this).text();
            var id = $(this).attr('data-id');
            // if(strstr($("#school-districtids").val(),id)){}
            ids += ","+id;
            names += ","+name;
        });
        console.log(names);
        console.log(ids);
        $("#school-districtids").val(ids.substr(1));   
        $("#school-districtnames").val(names.substr(1));
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
        function check (){
            if($("#school-districtids").val() == ''){
                return true;
            }
            var ary = $("#school-districtids").val().split(",");
            var nary=ary.sort();
            for(var i=0;i<ary.length;i++){  
                if (nary[i]==nary[i+1]){  
                    alert("小区存在重复内容："+nary[i]);
                    return false;
                }
            }
        }
    </script>
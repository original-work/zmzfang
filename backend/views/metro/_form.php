<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Area;

/* @var $this yii\web\View */
/* @var $model backend\models\Metro */
/* @var $form yii\widgets\ActiveForm */
$value = array();
$value = $model->attributes;

if(isset($value['region'])){
    $region = $value['region'];
}else{
    $region = '';
}
if(isset($value['longitude'])){
    $longitude = $value['longitude'];
}else{
    $longitude = '';
}
if(isset($value['latitude'])){
    $latitude = $value['latitude'];
}else{
    $latitude = '';
}
?>

<div class="metro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'metroline')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>
    <div id="allmap" style="width:400px;height:400px;"></div>
    <div>
    <div id="r-result">请输入:<input type="text" id="suggestId" size="20" value="" style="width:150px;" />&nbsp;<label><input type="checkbox"  id="allowClick">允许点击获取坐标</label></div>
    <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
    </div>


    <?= $form->field($model, 'region')->textInput(['readonly'=>'readonly']) ?>
    <?= $form->field($model, 'regioname')->textInput(['readonly'=>'readonly'],['maxlength' => true]) ?>
    <div class="form-group">
    <div id="tip" style="background:#ccc;">
    </div>
        
    </div>
    <input value="添加区域" data-toggle="modal" data-target="#myModal" type="button">

    


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
        <h4 class="modal-title" id="myModalLabel">增加区域</h4>
      </div>
      <div class="modal-body">
        <label>区域</label>
            <select class="form-control" id="metro-region2">
                <option>请选择区域</option>
                <?php foreach (Area::returnSchoolArea() as $key => $value){
                    // if($key == substr($region,2,2)){
                    //     echo "<option value = '$key' selected='selected'>$value</option>";
                    // }else{
                    //     
                    // }
                    echo "<option value = '$key'>$value</option>";
                }
                ?>
            </select>
            <div class="form-group">
                        <label class="control-label" for="metro-region-add">板块</label>
                        <select class="form-control" id="metro-region-add">
                            <option>请先选择区域</option>
                        </select>
            </div>
            <input type="button" value="增加" onclick="addTip($('#metro-region-add').val(),$('#metro-region-add :selected').text())">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>






<script src="/assets/js/jquery.min.js"></script>
<script src="http://www.zmzfang.com/weixin/js/area.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VtKDBNAwkIVrUse7fyKdlnUo"></script>
<script src="http://admin.zmzfang.com/common.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        InitTips();
        <?php if($region) :?>
        // var Ilist = getArea('13','<?=substr($region,2,2)?>','00','list');
        // initOption(Ilist);
        <?php endif; ?>
    });
    $('#metro-region2').on("change",function(){   
            var Slist = getArea('13',$(this).val(),'00','list');
            initOption(Slist);
            console.log(Slist);
    });

    function addTip(id,name) {
            var tipcon = '<span data-id = "'+id+'">' +name +
                '<span class="glyphicon glyphicon-remove del" onclick="$(this).parent().remove();initCid();"></span>' +
                '</span>&nbsp;&nbsp;&nbsp;';
            $('#tip').append(tipcon);
            initCid();

        }
    function InitTips(){
        if($("#metro-region").val() == ''){
            return false;
        }
        var ids = $("#metro-region").val().split(",");
        var names = $("#metro-regioname").val().split(",");
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
        $("#metro-region").val(ids.substr(1));   
        $("#metro-regioname").val(names.substr(1));
    }

    function initOption(Slist){
        var option ='<option value="">请选择板块</option>';
            var s = '';
            for(i in  Slist){
                // if (Slist[i]['value'] =='<?=$region?>') {
                //     s = "selected = 'selected'";
                // }else{
                //     s = '';
                // }
                option += "<option "+ s +" value='";
                option += Slist[i]['value'];
                option += "'>" + Slist[i]['text'] +"</option>";
            }
            $("#metro-region-add").html(option);
    }

    function check (){
            if($("#metro-region").val() == ''){
                return true;
            }
            var ary = $("#metro-region").val().split(",");
            var nary=ary.sort();
            for(var i=0;i<ary.length;i++){  
                if (nary[i]==nary[i+1]){  
                    alert("区域存在重复内容："+nary[i]);
                    return false;
                }
            }
        }
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var isnew = '<?=$latitude;?>'
    if(isnew){
        var point = new BMap.Point('<?=$longitude; ?>', '<?=$latitude?>');
        map.centerAndZoom(point, 16);
        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);               // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    }else{
        map.centerAndZoom("上海",15); 
    }
      // 添加带有定位的导航控件
  var navigationControl = new BMap.NavigationControl({
    // 靠左上角位置
    anchor: BMAP_ANCHOR_TOP_LEFT,
    // LARGE类型
    type: BMAP_NAVIGATION_CONTROL_LARGE,
    // 启用显示定位
    enableGeolocation: true
  });
  map.addControl(navigationControl);
  // 添加定位控件
  var geolocationControl = new BMap.GeolocationControl();
  geolocationControl.addEventListener("locationSuccess", function(e){
    // 定位成功事件
    var address = '';
    address += e.addressComponent.province;
    address += e.addressComponent.city;
    address += e.addressComponent.district;
    address += e.addressComponent.street;
    address += e.addressComponent.streetNumber;
    alert("当前定位地址为：" + address);
  });
  geolocationControl.addEventListener("locationError",function(e){
    // 定位失败事件
    alert(e.message);
  });
  map.addControl(geolocationControl);
  map.addEventListener("click",getLoc);
    function getLoc(e){
        // alert($('#allowClick').prop("checked"));
        if($('#allowClick').prop("checked")){
            alert(e.point.lng + "," + e.point.lat);
            $('#metro-longitude').val(e.point.lng);
            $('#metro-latitude').val(e.point.lat);
        }
    }
    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "suggestId"
        ,"location" : map
    });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
    var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
        
        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        $("#searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
    var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        $("#searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
        
        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            var marker = new BMap.Marker(pp)
            map.addOverlay(marker);               // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            $('#metro-longitude').val(pp.lng);
            $('#metro-latitude').val(pp.lat);
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
          onSearchComplete: myFun
        });
        local.search(myValue);
        alert(myValue);
    }
</script>
</div>

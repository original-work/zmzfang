<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\AreaConf;
/* @var $this yii\web\View */
/* @var $model backend\models\District */
/* @var $form yii\widgets\ActiveForm */
$value = $model->attributes;

$j = AreaConf::php2json('上海市');
$js = json_encode($j);  
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'districtid')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'districtname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <div id="allmap" style="width:400px;height:400px;"></div>
    <div><input type="button" onclick="getAutoLoc($('#district-districtname').val())" value="自动获取定位(通过小区名)">
    <input type="button" onclick="getAutoLoc($('#district-address').val())" value="自动获取定位(通过地址)">
    
    <div id="r-result">请输入:<input type="text" id="suggestId" size="20" value="" style="width:150px;" />&nbsp;<label><input type="checkbox"  id="allowClick">允许点击获取坐标</label></div>
    <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
    </div>
    <?= $form->field($model, 'longitude')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'latitude')->textInput(['readonly'=>'readonly']) ?>


    <?= $form->field($model, 'completedtime')->textInput() ?>

    <?= $form->field($model, 'region')->dropDownList($j['region'], ['prompt'=>'请选择','style'=>'width:120px'],['maxlength' => true]) ?>
    <div class="form-group field-district-region">
        <label class="control-label" for="district-plate">Plate</label>
        <select class="form-control" name="District[plate]" id="district-plate">
            <option>- 请先选择区域 -</option>
        </select>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('js'); ?> 
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=VtKDBNAwkIVrUse7fyKdlnUo"></script>
<script src="http://www.zmzfang.com/weixin/js/area.js"></script>

 <script type="text/javascript">
    var areajson = <?=$js?>;
    <?=($value['region'])?'initOption("'.$value['region'].'");':''?>
    <?php if($value['plate']) : ?>
    $('#district-plate').val("<?=$value['plate']?>")
    <?php endif; ?>
    

    $('#district-region').on("change",function(){
        initOption($(this).val());
    });
    function initOption(val){
        var option ='<option value="">- 请选择板块 -</option>';
            var s = '';
            for(i in areajson.block[val]){
                option += "<option value="+ areajson.block[val][i].code.substr(8,2) +">"+ areajson.block[val][i].plate +"</option>";
            }
            $("#district-plate").html(option);
    }
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var isnew = '<?=$value['latitude']?>'
    if(isnew){
        var point = new BMap.Point('<?=$value['longitude']?>', '<?=$value['latitude']?>');
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
            $('#district-longitude').val(e.point.lng);
            $('#district-latitude').val(e.point.lat);
        }
    }
    function getAutoLoc(loc){
        var myGeo = new BMap.Geocoder();
        alert(loc);
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(loc, function(point){
            if (point) {
                map.centerAndZoom(point, 18);
                var marker = new BMap.Marker(point);
                map.clearOverlays();
                map.addOverlay(marker);               // 将标注添加到地图中
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                $('#district-longitude').val(point.lng);
                $('#district-latitude').val(point.lat);
            }else{
                alert("没有解析到结果!");
            }
        }, "上海市");
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
            $('#district-longitude').val(pp.lng);
            $('#district-latitude').val(pp.lat);
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
          onSearchComplete: myFun
        });
        local.search(myValue);
        alert(myValue);
    }
</script>
<?php $this->endBlock('js'); ?> 
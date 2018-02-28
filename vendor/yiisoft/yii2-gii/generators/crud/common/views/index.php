
<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$modelClass = $generator->modelClass;
$mn = explode('\\', $modelClass);
$modelName = array_pop($mn);
$model = new $modelClass();
if(method_exists($model, 'getTableColumnInfo') == false){
    exit('error, ' . get_class($model) . ' no getTableColumnInfo method. can not use common (..\..\vendor\yiisoft\yii2-gii\generators\crud\common) to generated.');
}
// var_dump($modelClass);
// var_dump($modelClass->getTableColumnInfo());
// exit();
$tableColumnInfo = $model->getTableColumnInfo();
?>

<?="<?php\n" ?>
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use <?=$modelClass?>;

$modelLabel = new \<?=$modelClass?>();
?>

<div class="row">

	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>
					<i class="glyphicon glyphicon-user"></i>模块管理
				</h2>
				<div class="box-icon">
					<button id="create_btn" type="button"
						class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
					|
					<button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
				
				</div>
			</div>
			<div class="box-content">
			    <div id="msg_info">
                </div>
				<table id="data_table"
					class="table table-striped table-bordered bootstrap-datatable datatable responsive">
					<thead>
						<tr>
						<?= "<?php\n"?>
						      echo '<th><label><input id="data_table_check" type="checkbox"></label></th>';
						<?php foreach($tableColumnInfo as $key=>$column){?>      
						      echo '<th>' . $modelLabel->getAttributeLabel('<?=$key?>'). '</th>';
						<?php }?>      
						      ?>
						      <th>操作</th>
						</tr>
					</thead>
					<tbody>
					
		<?= "<?php\n" ?>
foreach ($models as $model) {
    echo '<tr id="rowid_' . $model->id . '">';
    echo '  <td><label><input type="checkbox" value="' . $model->id . '"></label></td>';
    <?php foreach($tableColumnInfo as $key=>$column){?>
    echo '  <td>' . $model-><?=$key ?> . '</td>';
    <?php }?>
   
    echo '  <td class="center">';
   
    echo '      <a id="view_btn" onclick="viewAction(' . $model->id . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
    echo '      <a id="edit_btn" onclick="editAction(' . $model->id . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
    echo '      <a id="delete_btn" onclick="deleteAction(' . $model->id . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
    echo '  </td>';
    echo '<tr/>';
}

?>
				
					</tbody>
				</table>
				
				<?= '<?= LinkPager::widget(["pagination" => $pages]); ?>' ?>
				
			</div>
		</div>
	</div>
	<!--/span-->

</div>
<!--/row-->




<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
                <?='<?php $form = ActiveForm::begin(["id" => "'.Inflector::camel2id(StringHelper::basename($generator->modelClass)).'-form", "class"=>"form-horizontal", "action"=>"index.php?r='.Inflector::camel2id(StringHelper::basename($generator->modelClass)).'/save"]); ?>' ?>
                
                <input type="hidden" class="form-control" id="id" name="<?=$modelName?>[id]" >
                <?php foreach($tableColumnInfo as $key=>$column){
                    if(strtolower($key) == 'id'){
                        continue;
                    }?>
                    
                    <div id="<?=$key?>_div" class="form-group">
    					<label for="<?=$key?>" class="col-sm-2 control-label"><?='<?php echo $modelLabel->getAttributeLabel("'.$key.'")?>'?></label>
    					<div class="col-sm-10">
    						<input type="text" class="form-control" id="<?=$key?>"
    							name="<?=$modelName.'['.$key.']'?>" placeholder="<?=$column['allowNull'] == false ? '必填' : ''?>">
    					</div>
    					<div class="clearfix"></div>
    				</div>
                <?php }?>
			<?= "<?php ActiveForm::end(); ?>" ?>
            </div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
					id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
			</div>
		</div>
	</div>
</div>

<script>

function viewAction(id){
	initModel(id, 'view', 'fun');
}

function initEditSystemModule(data, type){
	if(type == 'create'){
	<?php foreach($tableColumnInfo as $key=>$column){?>
	$("#<?=$key?>").val('');
	<?php }?>
	
	}
	else{
	<?php foreach($tableColumnInfo as $key=>$column){?>
	$("#<?=$key?>").val(data.<?=$key?>);
    <?php }?>
	}
	if(type == "view"){
	<?php foreach($tableColumnInfo as $key=>$column){?>
	$("#<?=$key?>").attr({readonly:true,disabled:true});
    <?php }?>
	$('#edit_dialog_ok').addClass('hidden');
	}
	else{
	<?php foreach($tableColumnInfo as $key=>$column){?>
	$("#<?=$key?>").attr({readonly:false,disabled:false});
    <?php }?>
	$('#edit_dialog_ok').removeClass('hidden');
	}
	$('#edit_dialog').modal('show');
}


function addAction(id){
	
}
function initModel(id, type, fun){
	
	$.ajax({
		   type: "GET",
		   url: "index.php?r=<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>/view",
		   data: {"id":id},
		   cache: false,
		   dataType:"json",
		   error: function (xmlHttpRequest, textStatus, errorThrown) {
			    alert("出错了，" + textStatus);
			},
		   success: function(data){
// 			   console.log(msg);
			   initEditSystemModule(data, type);
		   }
		});
}
function editAction(id){
	initModel(id, 'edit');
}

function deleteAction(id){
	var ids = [];
	if(!!id == true){
		ids[0] = id;
	}
	else{
		var checkboxs = $('#data_table :checked');
	    if(checkboxs.size() > 0){
	        var c = 0;
	        for(i = 0; i < checkboxs.size(); i++){
	            var id = checkboxs.eq(i).val();
	            if(id != ""){
	            	ids[c++] = id;
	            }
	        }
	    }
	}
	if(ids.length > 0){
		admin_tool.confirm('请确认是否删除', function(){
			console.log(this);
			///var csrf = $('meta[name="csrf-token"]').attr("content"); // "_csrf":csrf
		    $.ajax({
				   type: "GET",
				   url: "index.php?r=<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>/delete",
				   data: {"ids":ids},
				   cache: false,
				   dataType:"json",
				   error: function (xmlHttpRequest, textStatus, errorThrown) {
					    alert("出错了，" + textStatus);
					},
				   success: function(data){
					   for(i = 0; i < ids.length; i++){
						   $('#rowid_' + ids[i]).remove();
					   }
					   admin_tool.alert('msg_info', '删除成功', 'success');
				   }
				});
		});
	}
	else{
		admin_tool.alert('msg_info', '请先选择要删除的数据', 'warning');
	}
    
}
function getSelectedIdValues(formId)
{
	var value="";
	$( formId + " :checked").each(function(i)
	{
		if(!this.checked)
		{
			return true;
		}
		value += this.value;
		if(i != $("input[name='id']").size()-1)
		{
			value += ",";
		}
	 });
	return value;
}
$('#edit_dialog_ok').click(function (e) {
    e.preventDefault();
	$('#<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-form').submit();
});
$('#create_btn').click(function (e) {
    e.preventDefault();
    initEditSystemModule({}, 'create');
});
$('#delete_btn').click(function (e) {
    e.preventDefault();
    deleteAction('');
});

$('#<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-form').bind('submit', function(e) {
	e.preventDefault();
	var id = $("#id").val();
	var action = id == "" ? "create" : "update&id=" + id;
    $(this).ajaxSubmit({
    	type: "post",
    	dataType:"json",
    	url: "index.php?r=<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>/" + action,
    	success: function(value) 
    	{
    		//console.log(value);
        	if(value.errno == 0){
        		$('#edit_dialog').modal('hide');
        		admin_tool.alert('msg_info', '添加成功', 'success');
        	}
        	else{
            	var json = value.data;
        		for(var key in json){
        			console.log(key+':'+json[key]);
        			$('#' + key).attr({'data-placement':'bottom', 'data-content':json[key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');
        			
        		}
        	}

    	}
    });
});

</script>



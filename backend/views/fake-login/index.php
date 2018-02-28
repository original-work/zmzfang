<?php

/* @var $this yii\web\View */

$this->title = '模拟登陆';
?>
<form style="text-align:center;" action="http://admin.zmzfang.com/?r=fake-login" method="POST">
	<select onchange="check()" id="through"><option value="1">通过手机</option><option value="2">通过用户id</option></select>
	<input id="byphone" type="text" value="" name="phone" />
	<input id="byuserid" style="display:none;" type="text" value="" name="userid" />
	<input type="submit" value="预览">
</form>
<br />
<p style="text-align:center">搜索条件：手机号：<?=$phone?>,用户id：<?=$userid?></p>
<br />
<?php if($info): ?>
	<table class="table table-hover">
		<tr>
			<td>id</td>
			<td>picture</td>
			<td>nickname</td>
			<td>phone</td>
			<td>sex</td>			
		</tr>
		<tr>
			<td><?=$info['id']?></td>
			<td><img width="64" height="64" src="<?=$info['picture']?>"></td>
			<td><?=$info['nickname']?></td>
			<td><?=$info['phone']?></td>
			<td><?php if($info['sex']==1):echo "男";elseif($info['sex']==2): echo "女"; else: echo "未知" ; endif;?></td>
		</tr>
	</table>
	<form style="text-align:center;" target="_blank" action="http://www.zmzfang.com/?r=door/fake-login" method="POST">
		<input type="hidden" name="userid" value="<?=$info['id']?>">
		<input type="submit" value="确认登陆">
	</form>
<?php else: ?>
	<div style="border:1px solid #ccc;background:#ccc;padding:40px 300px;margin:0 auto;text-align:center">
		查无此人
	</div>
<?php endif; ?>
<script type="text/javascript">
	function check(){
		if( document.getElementById('through').value == 2){
			document.getElementById('byuserid').style.display='';
			document.getElementById('byphone').style.display='none';
			document.getElementById('byphone').value = ''
		}else{
			document.getElementById('byuserid').style.display='none';
			document.getElementById('byphone').style.display='';
			document.getElementById('byuserid').value = ''
		}
	}
</script>

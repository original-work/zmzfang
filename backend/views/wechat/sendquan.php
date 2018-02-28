<form action="http://admin.zmzfang.com/?r=wechat/sendquan" method="POST">
	<input type="text" name="openid" placeholder="输入用户的openid">
	<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
	<select name="id">
		<option value="767212">-5券</option>
		<option value="770615">-20券</option>
		<option value="783609">-44.99券</option>
	</select>
	<input type="submit" name="" value="提交">
</form>
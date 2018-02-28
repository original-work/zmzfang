<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id')->textInput() ?>

	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'count')->textInput() ?>

	<?= $form->field($model, 'time_start')->textInput() ?>

	<?= $form->field($model, 'time_end')->textInput() ?>
	<?= $form->field($model, 'read')->textInput() ?>
	<?= $form->field($model, 'status')->textInput() ?>
	<?= $form->field($model, 'source')->textInput() ?>

	<?= $form->field($model, 'short_desc')->textarea(['rows' => 6]) ?>
	<div class="form-group field-topic-describe">
		<label class="control-label" for="topic-describe">Describe</label>
			<br />
		<script id="topic-describe" type="text/plain"  name="Topic[describe]" ><?=$model->describe?></script>

		<div class="help-block"></div>
		<button onclick = 'getLastSave()' type="button">加载最后保存代码</button>
	</div>
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">window.UEDITOR_HOME_URL="/"; </script>
<script type="text/javascript" charset="utf-8" src="/assets/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/assets/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/assets/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">

	var ue = UE.getEditor('topic-describe',{
		textarea : 'Topic[describe]',
		maximumWords : 5000, //允许最大字数
	});
	function getLastSave() {
		ue.execCommand('drafts');
	}
</script>
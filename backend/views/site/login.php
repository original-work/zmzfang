<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="login-box">
  <div class="login-logo">
    <a href="<?=Url::toRoute('site/login')?>"><b>Yii</b>Boot</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
	<?php $form = ActiveForm::begin(['id' => 'login-form', 'action'=>Url::toRoute('site/login')]); ?>
    <!-- <form action="../../index2.html" method="post">   -->
      <div class="form-group has-feedback">
        <input name="username" id="username" type="text" class="form-control" placeholder="用户名" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" id="password" type="password" class="form-control" placeholder="密码">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input name="remember" id="remember" value="y" type="checkbox" /> &nbsp;记住我的登录
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button id="login_btn" type="button" class="btn btn-primary btn-block btn-flat">登录</button>
        </div>
        <!-- /.col -->
      </div>
    <!-- </form>  -->
    <?php ActiveForm::end(); ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script>
$('#login_btn').click(function (e) {
    e.preventDefault();
	$('#login-form').submit();
});
$('#login-form').bind('submit', function(e) {
	e.preventDefault();
    $(this).ajaxSubmit({
    	type: "post",
    	dataType:"json",
    	url: "<?=Url::toRoute('site/login')?>",
    	success: function(value) 
    	{
        	if(value.errno == 0){
        		window.location.reload();
        	}
        	else{
            	$('#username').attr({'data-placement':'top', 'data-content':'<span class="text-danger">用户名或密码错误</span>', 'data-toggle':'popover'}).addClass('popover-show').popover({html : true }).popover('show');
        	}

    	}
    });
});
</script>
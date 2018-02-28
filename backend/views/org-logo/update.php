<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgLogo */

$this->title = 'Update Org Logo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Org Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-logo-update">

    <h1><?= Html::encode($this->title) ?></h1>
	<p><img src="<?=$model->organizationlogo?>" /></p>
    <p><a href="./?r=org-logo/upload&id=<?=$model->id?>&filename=<?=$model->organizationkey?>">上传图片</a></p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

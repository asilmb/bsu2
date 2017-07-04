<?php

use yii\helpers\Html;

?>

<div class="pull-left">

	&copy; <?= Yii::$app->name . SPC . date('Y') ?>

	<?php if(YII_ENV_DEV) { ?>
		<span class="text-muted"> | </span>
		<?= Html::a(t('main', 'documentation'), param('url.frontend') . 'doc') ?>
	<?php } ?>

	<?php if(YII_ENV_DEV && config("modules.gii") && Yii::$app->user->can('backend.*')) { ?>
		<span class="text-muted"> | </span>
		<?= Html::a('Gii', ['/gii']) ?>
	<?php } ?>
	
	<?php if(APP == FRONTEND && Yii::$app->user->can('backend.*')) { ?>
		<span class="text-muted"> | </span>
		<?= Html::a(t('main', 'go_to_backend'), param('url.backend')) ?>
	<?php } ?>

	<?php if(config('modules.lang')) { ?>
		<span class="text-muted"> | </span>
		<?= t('lang/main', 'title') ?>: 
		<?= $this->render('@yii2module/lang/views/common/selector') ?>
	<?php } ?>
	
</div>

<div class="pull-right">
	<?= Yii::powered() ?>
</div>

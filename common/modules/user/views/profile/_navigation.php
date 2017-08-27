<?php

use yii\helpers\Url;

$currentAction = $this->context->action->id;
$actions = ['index', 'address', 'car', 'avatar', 'security', 'qr'];
?>

<ul class="nav nav-tabs" id="profile_navigation">
	<?php foreach($actions as $action) { ?>
		<li class="<?= $currentAction == $action ? 'active' : '' ?>">
			<a href="<?php echo Url::to([$action])?>">
				<?= t('user/profile', $action . '_title') ?>
			</a>
		</li>
	<? } ?>
</ul>

<style>
	#profile_navigation {
		margin-bottom: 15px;
	}
</style>

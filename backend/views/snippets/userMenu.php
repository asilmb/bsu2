<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$identity = Yii::$app->user->identity;

?>

<!-- Menu Toggle Button -->
<a href="#" class="dropdown-toggle" data-toggle="dropdown">

	<!-- The user image in the navbar-->
	<img src="<?= $identity->profile->avatar_url ?>" class="user-image" alt="User Image" />
	
	<!-- hidden-xs hides the username on small devices so only the image appears. -->
	<small class="hidden-xs"><?= $identity->username ?></small>
</a>

<ul class="dropdown-menu">

	<!-- The user image in the menu -->
	<li class="user-header">
		<img src="<?= $identity->profile->avatar_url ?>" class="img-circle" alt="User Image" />
		<p>
			<?= $identity->username ?>
		</p>
		<p>
			Web Developer
		</p>
	</li>
	
	<!-- Menu Footer-->
	<li class="user-footer">
		<div class="pull-left">
			<?= Html::a(t('user/profile', 'title'),['/user/admin/update', 'id' => $identity->id],['class'=>"btn btn-default btn-flat"]); ?>
		</div>
		<div class="pull-right">
			<?= Html::a(t('user/auth', 'logout_action'),['/user/auth/logout'],['class'=>"btn btn-default btn-flat", 'data-method'=>'post']); ?>
		</div>
	</li>
</ul>

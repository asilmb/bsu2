<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<?/* if ($this->beginCache('ADMIN_HEADER_PROFILE', [
	'duration' => 300,
	'variations' => [Yii::$app->language],
])): */?>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
	<ul class="nav navbar-nav">
		<!-- User Account Menu -->
		<? if(!Yii::$app->user->isGuest) { ?>
		<li class="dropdown user user-menu">
			<!-- Menu Toggle Button -->
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<!-- The user image in the navbar-->
				<img src="<?= Yii::$app->user->getAvatarUrl(true); ?>" class="user-image" alt="User Image" />
				<!-- hidden-xs hides the username on small devices so only the image appears. -->
				<span class="hidden-xs"><?= Yii::$app->user->getAttribute('username'); ?></span>
			</a>
			<ul class="dropdown-menu">
				<!-- The user image in the menu -->
				<li class="user-header">
					<img src="<?= Yii::$app->user->getAvatarUrl(true); ?>" class="img-circle" alt="User Image" />
					<p>
						<?= Yii::$app->user->getAttribute('username'); ?> - Web Developer
						<small><?= t('view','CREATED_AT {date}', ['date' => Yii::$app->formatter->asDatetime(Yii::$app->user->getAttribute('created_at'))]); ?></small>
					</p>
				</li>
				<!-- Menu Footer-->
				<li class="user-footer">
					<div class="pull-left">
						<?= Html::a(t('user/profile', 'title'),['/user/admin/update', 'id' => Yii::$app->user->getAttribute('id')],['class'=>"btn btn-default btn-flat"]); ?>
					</div>
					<div class="pull-right">
						<?= Html::a(t('user/auth', 'logout_action'),['/user/auth/logout'],['class'=>"btn btn-default btn-flat", 'data-method'=>'post']); ?>
					</div>
				</li>
			</ul>
		</li>
		<? } else { ?>
		<li>
			<a href="/user/auth/login">
				<?= t('user/auth', 'login_title') ?>
			</a>
		</li>
		<? } ?>
		<!-- Control Sidebar Toggle Button -->
		<li><?= Html::a('<i class="fa fa-external-link"></i>', param('url.frontend'), ['target' => '_blank', 'title' => t('view', 'BTN_ON_SITE_PAGE')]); ?></li>
	</ul>
</div>
<?
/* $this->endCache();
endif; */
?>
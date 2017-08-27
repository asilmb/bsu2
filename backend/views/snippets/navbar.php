<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii2lab\helpers\Page;

?>

<!-- Logo -->
<a href="<?= Url::to('/') ?>" class="logo">
	<!-- mini logo for sidebar mini 50x50 pixels -->
	<span class="logo-mini"><b>A</b>PL</span>
	<!-- logo for regular state and mobile devices -->
	<span class="logo-lg"><b>Admin</b>Panel</span>
</a>

<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
	
	<!-- Sidebar toggle button-->
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>
	
	<!-- Navbar Right Menu -->
	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
			
			<!-- User Account Menu -->
			<?php if(!Yii::$app->user->isGuest) { ?>
				<li class="dropdown user user-menu">
					<?= Page::snippet('userMenu') ?>
				</li>
			<?php } else { ?>
				<li>
					<a href="/user/auth/login">
						<?= t('user/auth', 'login_title') ?>
					</a>
				</li>
			<?php } ?>
			
			<!-- Control Sidebar Toggle Button -->
			<li>
				<?= Html::a('<i class="fa fa-external-link"></i>', param('url.frontend'), ['target' => '_blank', 'title' => t('main', 'go_to_frontend')]); ?>
			</li>
		</ul>
	</div>
</nav>

<?php

use yii\helpers\Url;
use yii2lab\helpers\Page;

?>

<!-- Logo -->
<a href="<?=Url::to('/') ?>" class="logo">
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
	<?= Page::snippet('userMenu') ?>
</nav>

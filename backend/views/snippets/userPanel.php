<div class="user-panel">
	<div class="pull-left image">
		<img src="<?= Yii::$app->user->identity->avatar ?>" class="img-circle" alt="User Image" />
	</div>
	<div class="pull-left info">
		<!-- Sidebar user panel (optional) -->
		<p><?= Yii::$app->user->identity->username ?></p>
		<!-- Sidebar Menu -->
		<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	</div>
</div>

<?php

/* @var $this yii\web\View */
/* @var $model \common\modules\user\forms\LoginForm */

use yii\helpers\Html;

$this->title = t('user/auth', 'login_title');
$this->params['breadcrumbs'][] = $this->title;

$loginForm = $this->render('helpers/_loginForm.php', [
	'model' => $model,
])

?>

<?php if(APP == BACKEND) { ?>

	<div class="login-box">
		<div class="login-logo">
			<?= Html::encode($this->title) ?>
		</div>
		<div class="login-box-body">
			<?= $loginForm ?>
			<?= Html::a(t('main', 'go_to_frontend'), param('url.frontend')) ?>
		</div>
	</div>

<?php } else { ?>

	<div class="user-login">
		<h1>
			<?= Html::encode($this->title) ?>
		</h1>
		<div class="row">
			<div class="col-lg-5">
				<?= $loginForm ?>
				<?= Html::a(t('user/auth', 'register_new_user'), ['/user/reg/signup']) ?>
				<br/>
				<?= Html::a(t('user/auth', 'i_forgot_my_password'), ['/user/password/reset-request']) ?>
				
			</div>
		</div>
	</div>

<?php } ?>

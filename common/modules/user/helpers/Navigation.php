<?php
namespace common\modules\user\helpers;

use Yii;
use yii2lab\helpers\yii\Html;
use common\widgets\Menu;
use common\widgets\DropdownMenu;

class Navigation {
	
	static function getMenu() {
		if(Yii::$app->user->isGuest) {
			return self::getGuestMenu();
		} else {
			return self::getUserMenu();
		}
	}
	
	private static function getItemList() {
		return [
			/* [
				'label' => 'My profile',
				'icon' => 'icon-user-plus',
				'url' => ['#'],
				'encode' => false,
			],
			[
				'label' => 'My balance',
				'icon' => 'icon-coins',
				'url' => ['#'],
				'encode' => false,
			],
			[
				'label' => 'Messages',
				'icon' => 'icon-comment-discussion',
				'badge' => '58',
				'badgeType' => 'warning',
				'url' => ['#'],
				'encode' => false,
			],
			[
				'options' => ['class'=>'divider'],
			],
			[
				'label' => 'Account settings',
				'icon' => 'icon-cog5',
				'url' => ['#'],
				'encode' => false,
			], */
			[
				'label' => t('user/auth', 'logout_action') . self::getLogoutForm(),
				//'icon' => 'icon-switch2',
				'url' => "javascript: $('#form_logout').submit()",
				'encode' => false,
			],
		];
	}
	
	private static function getGuestMenu()
	{
		$items = [];
		$items[] = ['label' => t('user/auth', 'login_action'), 'url' => ['/user/auth/login']];
		if(APP == FRONTEND) {
			$items[] = ['label' => t('user/auth', 'signup_action'), 'url' => ['/user/reg/signup']];
			$items[] = ['label' => t('user/password', 'title'), 'url' => ['/user/password/reset-request']];
		}
		return [
			'label' => 
				Html::fa('user') . NBSP . 
				t('user/auth', 'title'),
			'encode' => false,
			'items' => DropdownMenu::widget([
				'items' => $items,
			]),
		];
	}
	
	private static function getUserMenu()
	{
		$label = 
			Html::fa('user') . NBSP . 
			//'<img src="' . Yii::$app->user->getAvatarUrl(true) . '" class="user-image" alt="User Image" height="16"/>' . NBSP .
			Yii::$app->user->getAttribute('username');
		return [
			'label' => $label,
			/* 'options' => [
				'class' => 'dropdown dropdown-user',
			], */
			'encode' => false,
			'items' => DropdownMenu::widget([
				'items' => self::getItemList(),
			]),
		];
	}
	
	private static function getLogoutForm()
	{
		$url = ['/user/auth/logout'];
		$options = ['id' => 'form_logout', 'chass' => 'hide'];
		return 
			Html::beginForm($url, 'post', $options) . 
			Html::endForm();
	}
	
}

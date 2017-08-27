<?php

namespace common\modules\user\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\helpers\yii\Html;

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
				'label' => ['account/main','my_account'],
				'url' => 'account',
				'module' => 'user',
				'access' => ['@'],
			],
			[
				'label' => ['account/main','my_cards'],
				'url' => 'bank/card',
				'module' => 'bank',
				'access' => ['@'],
			],
			[
				'label' => ['account/main','my_profile'],
				'url' => 'user/profile',
				'module' => 'user',
				'access' => ['@'],
			],
			[
				'label' => t('user/auth', 'logout_action') . self::getLogoutForm(),
				'js' => "$('#form_logout').submit()",
				'encode' => false,
			],
		];
	}
	
	private static function getGuestMenu()
	{
		$items = [];
		$items[] = ['label' => ['user/auth', 'login_action'], 'url' => 'user/auth'];
		if(APP == FRONTEND) {
			$items[] = ['label' => ['user/registration', 'title'], 'url' => 'user/registration'];
			//$items[] = ['label' => ['user/password', 'title'], 'url' => 'user/password/reset-request'];
		}
		return [
			'label' => 
				Html::fa('user') . NBSP . 
				t('user/auth', 'title'),
			'encode' => false,
			'items' => $items,
		];
	}
	
	private static function getUserMenu()
	{
		$balance = Yii::$app->account->auth->getBalance()->active;
		$identity = Yii::$app->user->identity;
		//$avatar = Html::fa('user');
		$avatar = '<img src="'. $identity->profile->avatar_url . '" height="19" />';
		$label =
			$avatar . NBSP .
			'<small>'. 
				$identity->username . NBSP .
				'(Баланс: <b>'. floatval($balance) . '</b>)' .
			'</small>';
		return [
			'label' => $label,
			'encode' => false,
			'items' => self::getItemList(),
		];
	}
	
	private static function getLogoutForm()
	{
		$url = ['/user/auth/logout'];
		$options = ['id' => 'form_logout', 'chass' => 'hide'];
		return Html::beginForm($url, 'post', $options) . Html::endForm();
	}
	
}

<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class HomeCest
{
	public function checkOpen(FunctionalTester $I)
	{
		$I->amOnPage(\Yii::$app->homeUrl);
		$I->see('AdminPanel');
	}
}
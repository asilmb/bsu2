<?php
namespace frontend\tests\unit\helpers;

use Codeception\Test\Unit;
use yii\helpers\ArrayHelper;

class ArrayHelperTest extends Unit
{
	
	public function testArrayHelper()
	{
		$obj = new \stdClass();
		$obj->name  = 'Alex';
		$array = [
			'foo' => [
				'bar' => $obj,
			]
		];
		
		$value = ArrayHelper::getValue($array, 'foo.bar.name');
		expect($value)->equals('Alex');
	}

}

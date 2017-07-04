<?php
namespace api\tests\unit\helpers;

use yii\helpers\ArrayHelper;
use Codeception\Test\Unit;

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

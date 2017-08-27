<?php
namespace api\tests\unit\service\entities;

use Yii;
use api\v4\modules\service\entities\FieldEntity;
use Codeception\Test\Unit;

class FieldEntityTest extends Unit
{

	public $entity;

	public function _before() {
		//Yii::$app->summary->summary->setDriver('test');
	}
	
	public function __construct()
	{
		$this->entity = new FieldEntity([
			"name" => "account",
            "title" => "Телефон",
            "type" => "string",
            "min_length" => "",
            "max_length" => "11",
		]);
	}

	public function testGetCalcFields()
	{
		$entity2 = new FieldEntity([
			"name" => "button",
            "title" => "Button",
            "type" => "button",
		]);
		expect($this->entity->is_need_send)->equals(true);
		expect($entity2->is_need_send)->equals(false);
	}

}

<?php
namespace api\tests\unit\ddd\fields;

use api\v4\modules\service\ddd\fields\Entity;
use Codeception\Test\Unit;

class EntityTest extends Unit
{

	public $entity;

	public function __construct()
	{
		$this->entity = new Entity([
			"name" => "account",
            "title" => "Телефон",
            "type" => "string",
            "min_length" => "",
            "max_length" => "11",
		]);
	}

	public function testGetCalcFields()
	{
		$entity2 = new Entity([
			"name" => "button",
            "title" => "Button",
            "type" => "button",
		]);
		expect($this->entity->is_need_send)->equals(true);
		expect($entity2->is_need_send)->equals(false);
	}

}

<?php
namespace api\tests\unit\ddd\service;

use Codeception\Test\Unit;
use api\v4\modules\service\ddd\service\Entity;
use api\v4\modules\service\ddd\fields\Entity as FieldsEntity;

class EntityTest extends Unit {

	public $entity;
	public $toArray = [
		'id' => 7,
		'name' => 'goodline',
		'parent_id' => null,
		'description' => null,
		'title' => 'Good Line',
		'synonyms' => 'googlineee',
		'picture' => '77102591.png',
		'picture_url' => 'http://static.wooppay.com/image/service/77102591.png',
		'fields' => [
			[
				"name" => "account",
				"title" => "Phone",
				"type" => "string",
				"max_length" => "11",
				'is_need_send' => true,
			],
			[
				"name" => "button",
				"title" => "Button",
				"type" => "button",
				"is_need_send" => false,
			],
		],
	];
	
	public function __construct() {
		$this->entity = new Entity([
			'id' => 7,
			'name' => 'goodline',
			'title' => 'Good Line',
			'synonyms' => 'googlineee',
			'picture' => '77102591.svg',
			'fields' => [
				new FieldsEntity([
					"name" => "account",
					"title" => "Phone",
					"type" => "string",
					"max_length" => "11",
				]),
				[
					"name" => "button",
					"title" => "Button",
					"type" => "button",
				],
			],
		]);
	}

	public function testGettingVar() {
		expect('77102591.png')->equals($this->entity->picture);
		expect('http://static.wooppay.com/image/service/77102591.png')->equals($this->entity->picture_url);
		expect('77102591.png')->equals($this->entity->getPicture());
		expect('http://static.wooppay.com/image/service/77102591.png')->equals($this->entity->getPictureUrl());
	}

	public function testToArray() {
		expect($this->toArray['fields'][0])->equals($this->entity->fields[0]->toArray());
		expect($this->toArray['fields'][1])->equals($this->entity->fields[1]->toArray());
		expect($this->toArray)->equals($this->entity->toArray());
	}
	
	public function testToObject() {
		expect(new FieldsEntity($this->toArray['fields'][0]))->equals($this->entity->fields[0]);
		expect(new FieldsEntity($this->toArray['fields'][1]))->equals($this->entity->fields[1]);
	}
	
}

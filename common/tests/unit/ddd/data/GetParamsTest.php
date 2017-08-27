<?php
namespace common\tests\unit\helpers\ddd\data;

use Codeception\Test\Unit;
use common\ddd\data\GetParams;

class GetParamsTest extends Unit
{
	
	public function testGetQuery()
	{
		$getParams = new GetParams();
		$params = [
			'expand' => 'ddd,eee',
			'sort' => 'ddd,-eee',
			'fields' => 'ddd,eee',
			'page' => '3',
			'per-page' => '20',
			'category' => '177',
		];
		$query = $getParams->getAllParams($params);
		expect($query->data())->equals([
			'with' => [
				'ddd',
				'eee',
			],
			'order' => [
				'ddd' => SORT_ASC,
				'eee' => SORT_DESC,
			],
			'select' => [
				'ddd',
				'eee',
			],
			'where' => [
				'category' => '177',
			],
			'page' => 3,
			'per-page' => 20,
		]);
	}
	
	public function testGetQueryWithEmptyParams()
	{
		$getParams = new GetParams();
		$params = [];
		$query = $getParams->getAllParams($params);
		expect($query->data())->equals([]);
	}
	
	public function testGetParams()
	{
		$getParams = new GetParams();
		$params = [
			'expand' => 'ddd,eee',
			'sort' => 'ddd,-eee',
			'fields' => 'ddd,eee',
			'page' => '3',
			'per-page' => '20',
		];
		$convertedParams = $getParams->convertParams($params);
		expect($convertedParams)->equals([
			'expand' => [
				'ddd',
				'eee',
			],
			'sort' => [
				'ddd' => SORT_ASC,
				'eee' => SORT_DESC,
			],
			'fields' => [
				'ddd',
				'eee',
			],
			'page' => 3,
			'per-page' => 20,
		]);
	}
	
	public function testGetParamsWithCondition()
	{
		$getParams = new GetParams();
		$params = [
			'expand' => 'ddd,eee',
			'sort' => 'ddd,-eee',
			'fields' => 'ddd,eee',
			'page' => '3',
			'per-page' => '20',
			'category' => '177',
		];
		$convertedParams = $getParams->convertParams($params);
		expect($convertedParams)->equals([
			'expand' => [
				'ddd',
				'eee',
			],
			'sort' => [
				'ddd' => SORT_ASC,
				'eee' => SORT_DESC,
			],
			'fields' => [
				'ddd',
				'eee',
			],
			'page' => 3,
			'per-page' => 20,
			'where' => [
				'category' => '177',
			],
		]);
	}
	
}

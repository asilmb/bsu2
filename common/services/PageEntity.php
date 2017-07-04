<?php

namespace common\services;

use yii\base\Model;

class PageEntity extends Model {
	
	public $page = 1;
	public $perPage = 20;
	public $sort = [];
	public $condition = [];
	
}
<?php

namespace common\services;

interface DbInterface {
	
	public function one($pk);
	public function all();
	
}
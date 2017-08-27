<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class ActiveTypeFixture extends ActiveFixture
{
	public $tableName = '{{%active}}';
	public $dataFile = '@common/fixtures/data/active.php';
}
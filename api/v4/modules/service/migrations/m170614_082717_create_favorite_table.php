<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `favorite`.
*/
class m170614_082717_create_favorite_table extends Migration
{
	public $table = '{{%favorite}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'favorite_id' => $this->primaryKey(),
			'user_id' => $this->integer(),
			'billinginfo' => $this->text(),
			'amount' => $this->double(),
			'name' => $this->string(128),
			'status' => $this->integer(3)->defaultValue(1),
			'type' => $this->integer(3)->defaultValue(1),
			'position' => $this->integer(3)->defaultValue(1),
			'update_time' => $this->timestamp(),
			'create_time' => $this->timestamp(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndex(['user_id']);
	}

}

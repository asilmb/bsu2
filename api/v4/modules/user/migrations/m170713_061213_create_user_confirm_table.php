<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `user_confirm`.
*/
class m170713_061213_create_user_confirm_table extends Migration
{
	public $table = '{{%user_confirm}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'login' => $this->string(50),
			'action' => $this->string(32),
			'activation_code' => $this->integer(6),
			'created_at' => $this->timestamp(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['activation_code']);
	}

}

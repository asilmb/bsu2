<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `user_registration`.
*/
class m170512_090948_create_user_registration_table extends Migration
{
	public $table = '{{%user_registration}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'login' => $this->string(50),
			'email' => $this->string(100),
			'activation_code' => $this->string(10),
			'update_time' => $this->timestamp(),
			'create_time' => $this->timestamp(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['login']);
	}

}

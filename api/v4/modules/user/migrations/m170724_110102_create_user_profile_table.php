<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `user_profile`.
*/
class m170724_110102_create_user_profile_table extends Migration
{
	public $table = '{{%user_profile}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'login' => $this->string(16),
			'first_name' => $this->string(128)->comment('Имя'),
			'last_name' => $this->string(128)->comment('Фамилия'),
			'iin' => $this->string(128)->comment('ИИН'),
			'birth_date' => $this->timestamp()->comment('Дата рождения'),
			'sex' => $this->integer(1)->comment('пол (0: муж, 1: жен)'),
		];
	}

	public function afterCreate()
	{
		$this->myAddPrimaryKey(['login']);
	}

}

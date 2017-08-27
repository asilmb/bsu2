<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `user_car`.
*/
class m170823_054932_create_user_car_table extends Migration
{
	public $table = '{{%user_car}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'login' => $this->string(16),
			'gov_number' => $this->string()->comment('Гос. номер'),
			'document_number' => $this->string()->comment('Номер тех. паспорта'),
		];
	}
	
	public function afterCreate()
	{
		$this->myAddPrimaryKey(['login']);
	}

}

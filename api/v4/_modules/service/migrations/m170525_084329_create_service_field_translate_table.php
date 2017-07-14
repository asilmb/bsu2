<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_field_translate`.
*/
class m170525_084329_create_service_field_translate_table extends Migration
{
	public $table = '{{%service_field_translate}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_id' => $this->integer(),
			'service_field_name' => $this->string(50),
			'value' => $this->string(255),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['service_id', 'service_field_name']);
		$this->myAddForeignKey(
			'service_id',
			'{{%service}}',
			'service_id',
			'CASCADE',
			'CASCADE'
		);
	}

}

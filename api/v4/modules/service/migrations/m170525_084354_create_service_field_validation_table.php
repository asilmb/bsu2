<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_field_validation`.
*/
class m170525_084354_create_service_field_validation_table extends Migration
{
	public $table = '{{%service_field_validation}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_field_validation_id' => $this->primaryKey(),
			'service_field_id' => $this->integer(),
			'type' => $this->string(45),
			'param' => $this->string(),
		];

	}

	public function afterCreate()
	{
		$this->myCreateIndex('service_field_id');
		$this->myAddForeignKey(
			'service_field_id',
			'{{%service_field}}',
			'service_param_id',
			'CASCADE',
			'CASCADE'
		);
	}

}

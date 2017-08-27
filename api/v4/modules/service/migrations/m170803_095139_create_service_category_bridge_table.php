<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_category_bridge`.
*/
class m170803_095139_create_service_category_bridge_table extends Migration
{
	public $table = '{{%service_category_bridge}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'category_id' => $this->integer(),
			'service_id' => $this->integer(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['category_id', 'service_id']);
	}

}

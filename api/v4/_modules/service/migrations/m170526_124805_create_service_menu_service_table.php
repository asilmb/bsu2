<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_menu_service`.
*/
class m170526_124805_create_service_menu_service_table extends Migration
{
	public $table = '{{%service_menu_service}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_menu_id' => $this->integer(),
			'service_id' => $this->integer(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndexUnique(['service_menu_id', 'service_id']);
	}

}

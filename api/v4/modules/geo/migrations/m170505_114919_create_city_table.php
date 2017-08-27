<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `city`.
*/
class m170505_114919_create_city_table extends Migration
{
	public $table = '{{%city}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'id_country' => $this->integer(),
			'region_id' => $this->integer(),
			'city_name' => $this->string(255),
			'position' => $this->integer(),
			'status' => $this->integer(),
			'date_change' => $this->timestamp(),
		];

	}

	public function afterCreate()
	{
		$this->myCreateIndex('id_country');
		$this->myCreateIndex('position');
		$this->myAddForeignKey(
			'id_country',
			'{{%country}}',
			'code',
			'CASCADE',
			'CASCADE'
		);
	}

}

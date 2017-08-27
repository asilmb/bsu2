<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_field_option`.
*/
class m170802_093309_create_active_field_option_table extends Migration
{
	public $table = '{{%active_field_option}}';
	public $comment = 'Значение поей типа select';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'field_id' => $this->integer()->notNull()->comment('ID поля'),
			'key' => $this->string()->notNull(),
			'title' => $this->string()->notNull(), // {entity: "city",field: "city_name"}
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'field_id',
			'{{%active_field}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}

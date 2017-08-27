<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_menu`.
*/
class m170525_090917_create_service_menu_table extends Migration
{
	public $table = '{{%service_menu}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'parent_id' => $this->integer(),
			'name' => $this->text(),
			'title' => $this->text(),
			'position' => $this->integer(),
			'picture' => $this->text(),
			'pic_white' => $this->text(),
			'background' => $this->string(50),
			'modify_date' => $this->timestamp(),
			'description' => $this->string(500),
			'banners_html' => $this->text(),
			'banners_locale' => $this->string(255),
			'new' => $this->integer(1),
			'group_id' => $this->integer(),
			'synonyms' => $this->string(255)->defaultValue('{}'),
			'status' => $this->integer()->defaultValue(1),
		];

	}

	public function afterCreate()
	{
		$this->myCreateIndex('parent_id');
		$this->myAddForeignKey(
			'parent_id',
			'{{%service_menu}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}

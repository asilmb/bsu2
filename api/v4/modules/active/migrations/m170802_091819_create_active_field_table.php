<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_field`.
*/
class m170802_091819_create_active_field_table extends Migration
{
	public $table = '{{%active_field}}';
	public $comment = 'Поля типов активов';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'name' => $this->string()->notNull(),
			'title' => $this->string()->notNull(),
			'active_id' => $this->integer()->notNull()->comment('ID типа актива'),
			'type' => $this->string()->notNull()->comment('Тип значения'),
			'sort' => $this->integer()->comment('Позиция'),
			'is_hidden' => $this->integer(1)->notNull()->defaultValue(0)->comment('Рендарить поле'),
			'is_visible' => $this->integer(1)->notNull()->defaultValue(0)->comment('Скрывать поле'),
			'is_has_button' => $this->integer(1)->notNull()->defaultValue(0)->comment('Имеет ли кнопку'),
			'is_readonly' => $this->integer(1)->notNull()->defaultValue(0)->comment('Только для чтения'),
			'priority' => $this->integer()->comment('Приоритет отображения'),
			'mask' => $this->string()->comment('Маска строки'),
		];
	}
	
	public function afterCreate()
	{
		$this->myAddForeignKey(
			'active_id',
			'{{%active}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}

<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_field_validation`.
*/
class m170802_092827_create_active_field_validation_table extends Migration
{
	public $table = '{{%active_field_validation}}';
	public $comment = 'Правила валидации полей';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'field_id' => $this->integer()->notNull()->comment('ID поля'),
			'type' => $this->string()->notNull()->comment('Метод'),
			'rules' => $this->string()->null()->comment('Массив правил'),
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

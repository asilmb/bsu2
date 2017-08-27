<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_provider`.
*/
class m170802_093267_create_active_provider_table extends Migration
{
	public $table = '{{%active_provider}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'description' => $this->string(),
			'logo' => $this->string(),
			'background_color' => $this->string(6),
			'font_color' => $this->string(6),
			'type_id' => $this->integer()->notNull(),
			'bik' => $this->integer(),
			'api_sign' => $this->integer(),
			
		];
	}

	public function afterCreate()
	{
		
	}

}

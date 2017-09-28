<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `extra_news`.
*/
class m170928_103046_create_extra_news_table extends Migration
{
	public $table = '{{%extra_news}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
            'title' => $this->string(),
            'anons' => $this->string(),
            'create_time' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
		];

	}

	public function afterCreate()
	{
		
	}

}

<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service`.
*/
class m170523_135653_create_service_table extends Migration
{
	public $table = '{{%service}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_id' => $this->primaryKey(),
			'service_name' => $this->string(50),
			'parent_id' => $this->integer(),
			'merchant' => $this->string(255),
			'name' => $this->text(),
			'title' => $this->text(),
			'description' => $this->text(),
			'description_company' => $this->text(),
			'choice_service_text' => $this->text(),
			'site' => $this->text(),
			'picture' => $this->text(),
			'pic_prefix' => $this->string(50),
			'background' => $this->string(50),
			'library_date' => $this->timestamp(),
			'instruction' => $this->text(),
			'contacts' => $this->text(),
			'services_more' => $this->text(),
			'tariff' => $this->text(),
			'min_sum' => $this->text(),
			'max_sum' => $this->text(),
			'enrollment_time' => $this->text(),
			'fast_input' => $this->text(),
			'commission_info' => $this->text(),
			'status' => $this->integer(3),
			'modify_date' => $this->timestamp(),
			'priority' => $this->integer(),
			'type' => $this->integer(3),
			'info' => $this->text(),
			'acquiring_access' => $this->integer(3)->defaultValue(1),
			'template' => $this->string(100),
			'synonyms' => $this->string(255),
			'fields' => $this->string(4096),
			'subtitle' => $this->string(),
			'subtitle_projects' => $this->integer(),
			'sms_confirmation' => $this->integer(1),
		];

	}

	public function afterCreate()
	{
		$this->myCreateIndex('parent_id');
		$this->myCreateIndex('status');
		$this->myCreateIndexUnique(['service_name', 'merchant', 'status']);
	}

}

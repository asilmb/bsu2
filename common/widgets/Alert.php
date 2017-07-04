<?php

namespace common\widgets;

use Yii;
use kartik\widgets\Alert as kartikAlert;

/**
 * Extends the \yii\bootstrap\Alert widget with additional styling and auto fade out options.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Alert extends kartikAlert
{
	/**
	 * @var bool auto fill data
	 */
	public $autoFill = true;
	public $typeList = [
		parent::TYPE_INFO, 
		parent::TYPE_DANGER, 
		parent::TYPE_SUCCESS, 
		parent::TYPE_WARNING, 
		parent::TYPE_PRIMARY, 
		parent::TYPE_DEFAULT, 
		parent::TYPE_CUSTOM
	];

	/**
	 * Init widget
	 */
	public function init()
	{
		if(Yii::$app->getResponse()->getStatusCode() != 302) {
			if($this->autoFill) {
				$find = false;
				foreach($this->typeList as $type) {
					if (Yii::$app->session->hasFlash($type)) {
						$this->type = $type;
						$this->body = Yii::$app->session->getFlash($type);
						$find = true;
						break;
					}
				}
				if(!$find) {
					$this->type = parent::TYPE_INFO;
				}
			}
			if(!empty($this->body)) {
				parent::init();
			}
		}
	}

	/**
	 * Runs the widget
	 */
	public function run()
	{
		if(!empty($this->body)) {
			parent::run();
		}
	}
	
	public function add($body, $type = parent::TYPE_INFO)
	{
		if(is_array($body)) {
			$body = t($body[0], $body[1]);
		}
		Yii::$app->session->setFlash($type, $body);
	}
	
}

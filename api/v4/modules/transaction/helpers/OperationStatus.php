<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 03.08.2017
 * Time: 17:41
 */

namespace api\v4\modules\transaction\helpers;


class OperationStatus {
	
	const CREATED = 11;
	
	const CONFIRMED = 12;
	
	const REJECTED = 13;
	
	const FINISHED = 14;
	
	const CANCELLED = 15;
	
	const STORNING = 16;
	
	const DELETED = 17;
	
	const KVITED = 18;
	
	const MERCHANT_WAITING = 19;
	
	const DELETED_VISIBLE = 20;
	
	
	/**
	 * @inheritdoc
	 */
	public static function getKeys() {
		return array(
			"CREATED",
			"CONFIRMED",
			"REJECTED",
			"FINISHED",
			"CANCELLED",
			"STORNING",
			"DELETED",
			"KVITED",
			"MERCHANT_WAITING",
			"DELETED_VISIBLE",
		);
	}
}
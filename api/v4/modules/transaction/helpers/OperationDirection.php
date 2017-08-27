<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 03.08.2017
 * Time: 17:40
 */

namespace api\v4\modules\transaction\helpers;


class OperationDirection {
	
     const INCOMING = "incoming";
	 const OUTGOING = "outgoing";
	 const EXTERNAL = "external";
	
	/**
	 * @inheritdoc
	 */
	public static function getKeys() {
		return array(
			"INCOMING",
			"OUTGOING",
			"EXTERNAL",
		);
	}
}
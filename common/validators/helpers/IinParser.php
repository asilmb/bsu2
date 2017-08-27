<?php

namespace common\validators\helpers;

use Exception;

class IinParser {
	
	public static function parse($value) {
		$part['date'] = IinDateHelper::parseDate($value);
		$part['number'] = substr($value, 7, 4);
		$part['sex'] = self::getSex($value);
		self::validateSum($value);
		return $part;
	}
	
	private static function validateSum($value) {
		$sum = intval(substr($value, 11, 1));
		$sumCalculated = self::generateSum($value);
		if($sum != $sumCalculated) {
			throw new Exception();
		}
	}
	
	private static function getSex($value) {
		$century = IinDateHelper::parseCentury($value);
		return !empty($century % 2) ? 'male' : 'female';
	}
	
	private static function generateSum($inn) {
		$multiplication = 7 * $inn[0] + 2 * $inn[1] + 4 * $inn[2] + 10 * $inn[3] + 3 * $inn[4] + 5 * $inn[5] + 9 * $inn[6] + 4 * $inn[7] + 6 * $inn[8] + 8 * $inn[9];
		$sum = $multiplication % 11 % 10;
		return $sum;
	}
	
}

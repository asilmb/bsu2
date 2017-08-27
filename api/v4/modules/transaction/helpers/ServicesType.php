<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 02.08.2017
 * Time: 15:35
 */

namespace api\v4\modules\transaction\helpers;


class ServicesType
{
	const BILLING = 0;
	
	const NOT_BILLING = 1;
	
	const TRANSFER = 2;
	
	const PREPROCESSING = 3;
	
	const INVOICE = 4;
	
	const WITHDRAWAL_BANK = 5;
	
	const SYSTEM = 6;
	
	const PARENT = 7;
	
	const ADDRESSLESS_TRANSFER = 8;
	
	const WITHDRAWAL_CARD = 9;
	
	const ACQUIRING = 10;
	
	const CUSTOM_DONATE = 11;
	
	const CUSTOM_INVOICE = 12;
	
	const STORNING = 13;
	
	const INVOICE_SMS = 14;
	
	const QR_PAYMENT = 15;
	
	const ATM_CASHOUT = 16;
	
	const KAZPOST_CASHOUT = 17;
	
	const MAILRU_INVOICE = 18;
	
	
	/**
	 * @inheritdoc
	 */
	public static function getKeys()
	{
		return array(
			"BILLING",
			"NOT_BILLING",
			"TRANSFER",
			"PREPROCESSING",
			"INVOICE",
			"WITHDRAWAL_BANK",
			"SYSTEM",
			"PARENT",
			"ADDRESSLESS_TRANSFER",
			"WITHDRAWAL_CARD",
			"ACQUIRING",
			"CUSTOM_DONATE",
			"CUSTOM_INVOICE",
			"STORNING",
			"INVOICE_SMS",
			"QR_PAYMENT",
			"ATM_CASHOUT",
			"KAZPOST_CASHOUT",
			"MAILRU_INVOICE",
		);
	}
}
<?php

namespace api\v4\modules\bank\helpers;

use Yii;
use yii\helpers\Html;
use yii2woop\tps\models\BaseCardOperation;

class AcquiringHelper {
	const TEMPLATE_COMMAND = 'command_template.xml';
	const TEMPLATE_PAYMENT = 'template.xml';

	private $_path;
	private $_config;
	private $_prvkey;
	private $_pubkey;
	private $_type;

	public function __construct($type = null, $path = null) {
		//todo: add keys to wp_test/wp folders
		if($type === null){
			$this->_type = Yii::$app->params['AcquiringType'];
		} elseif ($type == BaseCardOperation::TYPE_CNP) {
			$this->_type = BaseCardOperation::TYPE_CNP;
		} elseif ($type == BaseCardOperation::TYPE_WOOPPAY) {
			$this->_type = BaseCardOperation::TYPE_WOOPPAY;
		} else {
			$this->_type = BaseCardOperation::TYPE_EPAY;
		}
		if (!$path) {
			if ($type == BaseCardOperation::TYPE_CNP) {
				$this->_path = Yii::$app->params['CnpPath'];
			} elseif ($type == BaseCardOperation::TYPE_WOOPPAY) {
				$this->_path = Yii::$app->params['WooppayPath'];
			} else {
				$this->_path = Yii::$app->params['EpayPath'];
			}
		} else {
			$this->_path = $path;
		}
		$config = $this->_path . 'config.txt';
		if (file_exists($config) && is_readable($config)) {
			$this->_config = parse_ini_file($config);
		} else {
			die('config not found');
		}

		$key = file_get_contents($this->_path . $this->_config['PRIVATE_KEY_FN']);
		/*$prvkey = openssl_pkey_get_private($key, $this->_config['PRIVATE_KEY_PASS']);
		if ($prvkey) {
			$this->_prvkey = $prvkey;
		} else {
			var_dump(openssl_error_string());
			die('failed to load private key');
		}*/
		$key = file_get_contents($this->_path . $this->_config['PUBLIC_KEY_FN']);
		$pubkey = openssl_pkey_get_public($key);
		if ($pubkey) {
			$this->_pubkey = $pubkey;
		} else {
			die('failed to load public key');
		}
	}

	public function sign($data) {
		if (openssl_sign($data, $sign, $this->_prvkey)) {
			return base64_encode(strrev($sign));
		}
		die('failed to sign data');
	}

	public function check($data, $sign) {
		return true;
		$result = openssl_verify($data, strrev(base64_decode($sign)), $this->_pubkey);
		if ($result == 1) {
			return true;
		} elseif ($result == 0) {
			return false;
		} else {
			die('signature verification failed');
		}
	}

	public function encrypt($data) {
		$key = mhash(MHASH_SHA256, $this->_config['PRIVATE_KEY_PASS']);
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB));
		return $encrypted;
	}

	public function decrypt($data) {
		$key = mhash(MHASH_SHA256, $this->_config['PRIVATE_KEY_PASS']);
		$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB);
		return $decrypted;
	}

	public function parse($template, $data = array()) {
		switch ($template) {
			case self::TEMPLATE_COMMAND:
				$template = $this->_config['XML_COMMAND_TEMPLATE_FN'];
				break;
			case self::TEMPLATE_PAYMENT:
				$template = $this->_config['XML_TEMPLATE_FN'];
				break;
			default:
				die('unknown template');
		}
		$xml = file_get_contents($this->_path . $template);
		if (preg_match_all('%\[([A-Z_\-]*?)\]%is', $xml, $match)) {
			foreach ($match[1] as $replace) {
				if (isset($this->_config[$replace])) {
					$xml = str_replace('[' . $replace . ']', $this->_config[$replace], $xml);
				} elseif (isset($data[$replace])) {
					$xml = str_replace('[' . $replace . ']', $data[$replace], $xml);
				} else {
					die($replace . ' not found');
				}
			}
		}
		return $xml;
	}

	public function xml($document, $sign) {
		$result_sign = '<merchant_sign type="RSA">'.$sign.'</merchant_sign>';
		$result = "<document>".$document.$result_sign."</document>";
		return base64_encode($result);
	}

	public static function processPayment($order, $amount, $currency, $type = null) {
		$acquiring = new AcquiringHelper($type);
		$data = array(
			'ORDER_ID' => sprintf("%06d", $order),
			'AMOUNT' => $amount,
			'CURRENCY' => $currency,
		);
		$document = $acquiring->parse(AcquiringHelper::TEMPLATE_PAYMENT, $data);
		$sign = $acquiring->sign($document);
		$xml = $acquiring->xml($document, $sign);
		return $xml;
	}

	public static function processResponse($response, $type = null) {
		$xml = simplexml_load_string($response);
		if (!$xml) {
			return false;
		}
		if (!isset($xml->bank)
				|| !isset($xml->bank->customer)
				|| !isset($xml->bank->customer->merchant)
				|| !isset($xml->bank->customer->merchant->order)
				|| !isset($xml->bank->customer->merchant->order['order_id'])
				|| !isset($xml->bank->results)
				|| !isset($xml->bank->results->payment)
				|| !isset($xml->bank->results->payment['response_code'])
				|| !isset($xml->bank_sign)) {
			return false;
		}
		$pos1 = strpos($response, '<bank');
		$pos2 = strpos($response, '<bank_sign');
		$document = substr($response, $pos1, $pos2 - $pos1);
		$order = intval($xml->bank->customer->merchant->order['order_id']);
		$sign = (string)$xml->bank_sign;
		$acquiring = new AcquiringHelper($type);
		if ($acquiring->check($document, $sign)) {
			$response = (string)$xml->bank->results->payment['response_code'];
			return array(
				'order' => $order,
				'response_code' => $response,
			);
		}
		return false;
	}

	/**
	 * @param object $params
	 * @return string
	 */
	public static function toHiddenFields($params) {
		$fields = array_map(function($key, $value) {
			return Html::hiddenInput($key, $value);
		}, array_keys((array)$params), array_values((array)$params));
		return join('', $fields);
	}
}
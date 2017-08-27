<?php

namespace api\v4\modules\user\helpers;

class LoginHelper {
	
	protected static $prefixList = ['B', 'BS', 'R'];

	public static function format($login, $mask = null)
	{
		if(!self::validate($login)) {
			return $login;
		}
		$splitLogin = self::splitLogin($login);
		$parts = self::splitPhone($splitLogin['phone']);
		if(empty($mask)) {
			$mask = param('user.login.mask');
		}
		return vsprintf($mask, $parts);
	}

	public static function parse($login)
	{
		$login = self::pregMatchLogin($login);
		return self::splitLogin($login);
	}
	
	/**
	 * @param string $login
	 * @return string
	 */
	public static function pregMatchLogin($login)
	{
		$login = self::cleanLoginOfChar($login);
		$login = self::replaceCountryCode($login);
		return $login;
	}

	public static function splitPhone($phone)
	{
		$parts['country'] = substr($phone,0,1);
		$parts['operator'] = substr($phone,1,3);
		$parts['group1'] = substr($phone,4,3);
		$parts['group2'] = substr($phone,7,2);
		$parts['group3'] = substr($phone,9,2);
		return $parts;
	}

	public static function splitLogin($login)
	{
		$result['prefix'] = '';
		$result['phone'] = $login;
		if (preg_match('/^(' . self::getPrefixExp() . ')([\s\S]+)$/', $login, $match)){
			$result['prefix'] = $match[1];
			$result['phone'] = $match[2];
		}
		return $result;
	}
	
	public static function validate($login)
	{
		$login = self::cleanLoginOfChar($login);
		$login = self::replaceCountryCode($login);
		return (boolean) preg_match('/^(' . self::getPrefixExp() . ')?([\d]{11})$/', $login);
	}
	
	protected static function cleanLoginOfChar($login)
	{
		$login = str_replace(['+', ' ', '-', '(', ')'], '', $login);
		return $login;
	}
	
	protected static function replaceCountryCode($login)
	{
		if (preg_match('/^(' . self::getPrefixExp() . ')?87([\s\S]+)$/', $login, $match)){
			$login = $match[1] . '77' . $match[2];
		}
		return $login;
	}
	
	protected static function getPrefixExp()
	{
		$prefixList = self::$prefixList;
		usort($prefixList, 'sortByLen');
		return implode('|', $prefixList);
	}
	
}

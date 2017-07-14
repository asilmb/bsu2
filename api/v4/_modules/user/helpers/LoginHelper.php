<?php

namespace api\v4\modules\user\helpers;

class LoginHelper {
	
	protected static $prefixList = ['B', 'BS', 'R'];
	
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

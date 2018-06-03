<?php

namespace vendor\auxiliary;

final class SessionManager
{
	public const EXPIRE_TIME = 259200;
	
	public static function start()
	{
		session_start();
	}
	
	public static function setSessionProperty(string $key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	public static function setCookieProperty(string $key, $value, int $expireTime = self::EXPIRE_TIME)
	{
		setcookie($key, $value, time() + $expireTime);
	}
	
	public static function getSessionProperty(string $key)
	{
		return $_SESSION[$key];
	}
	
	public static function getCookieProperty(string $key)
	{
		return $_COOKIE[$key];
	}
	
	public static function unsetSessionProperty(string $key)
	{
		$_SESSION[$key] = null;
	}
	
	public static function unsetCookieProperty(string $key)
	{
		setcookie($key, "", time() - 1);
	}
	
	public static function end()
	{
		session_write_close();
	}
}
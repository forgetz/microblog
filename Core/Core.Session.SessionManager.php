<?php //namespace Core.Session
//session_set_cookie_params('3600','/','agere.co.th', true,true);
session_start();
 

class SessionManager
{
	public static function GetSession($key)
	{
		if (isset($_SESSION) && array_key_exists($key, $_SESSION))
			return $_SESSION[$key];
		return null;
	}
	
	public static function SetSession($key,$value)
	{
		 $_SESSION[$key] = $value;
	}	
	
	public static function UnSetSession($key)
	{
		unset($_SESSION[$key]);	
	}
	
	public static function ClearSessions()
	{
		session_destroy();
		//foreach($_SESSION as $key=>$value)
		//{
		//	SessionManager::UnSetSession($key);
		//}
		
	}

}

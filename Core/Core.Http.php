<?php
require_once(realpath(dirname(__FILE__))."/Core.String.php");

class Http  
{
	public static function IsPostBack()
	{
		return (!empty($_POST) || count($_POST) > 0 || !empty($_FILES) || count($_FILES) > 0);
	}

	public static function GetHttpPost($key)
	{
		if (!Http::IsExistingHttpPost($key))
			return null;

		$value = $_POST[$key];

		if (!is_array($value))
		{
			if( String::DetectXSS($value))
			{
				$value = strip_tags($value);
			}
			return $value;
		}

		foreach($value as $k=>$v)
		{
			if(String::DetectXSS($v))
			{
				$value = strip_tags($v);
			}
		}
		return $value;
		

	}
	
	public static function GetHttpGet($key)
	{
		if (!Http::IsExistingHttpGet($key))
			return null;
		
		$value = $_GET[$key];
		if (String::DetectXSS($value))
			$value = strip_tags($value);
		
		return $value;
	}

	public static function IsExistingHttpPost($key)
	{
		return array_key_exists($key, $_POST);	
	}

	public static function IsExistingHttpGet($key)
	{
		return array_key_exists($key, $_GET);	
	}

	public static function GetIP()
	{ 
		$ip = '';
		if (isset($_SERVER["REMOTE_ADDR"])) 
			$ip = $_SERVER["REMOTE_ADDR"]; 
		else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
		else if (isset($_SERVER["HTTP_CLIENT_IP"])) 
			$ip = $_SERVER["HTTP_CLIENT_IP"]; 
		return $ip; 
	}

	public static function Redirect($url)
	{
		//$url	=	urlencode($url);
		echo String::Format("<script  language='JavaScript'> window.location = \"{0}\"; </script>", $url);	
	}

	public static function GetCurrentURIPath()
	{
		$SERVER_NAME = $_SERVER["HTTP_HOST"];
		$SERVER_PORT = $_SERVER["SERVER_PORT"];
		$REQUEST_URI = dirname($_SERVER['PHP_SELF']);
		$SERVER_PROTOCAL =  ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' );
		return $SERVER_PROTOCAL . $SERVER_NAME .":". $SERVER_PORT. $REQUEST_URI;
	}

}
 
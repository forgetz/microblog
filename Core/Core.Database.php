<?php  //namespace Core\Database;
require_once(realpath(dirname(__FILE__))."/Core.Configuration.php");
require_once(realpath(dirname(__FILE__))."/Core.String.php");

class Database
{
	function __construct() 
	{
		Configuration::Initializing();	
	}

	public static function Instance()
	{
		return new MySQL();	
	}
	
	//$store_procedure is a set of string of storeprocedure to execute
	//return type is a number of ID (it's an auto increment id are inserted.)
	public function ExecNonQuery($sql)
	{
		$DB_HOST			= Configuration::$DB_HOST;
		$DB_USER				= Configuration::$DB_USER;
		$DB_PASSWORD	= Configuration::$DB_PASSWORD;
		$DB_NAME			= Configuration::$DB_NAME;

		$conn = mysql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
		
		mysql_select_db($DB_NAME,$conn);
		mysql_query("SET NAMES UTF8");
		date_default_timezone_set(Configuration::$TIMEZONE);

		 
		if(is_array($sql))
		{
			$result=null;
			foreach($sql as $key=>$value)
			{
				mysql_query($value, $conn) or die ('ERROR: '.$value.' : '.mysql_error ());
				$result[] = MySQL::GetExecuteNonQueryResult($value);
			}
		}
		else
		{
			mysql_query($sql, $conn) or die ('ERROR: '.$sql.' : '.mysql_error ());
			$result = MySQL::GetExecuteNonQueryResult($sql);
		} 
		
		return $result;
	}

	private static function GetExecuteNonQueryResult($sql)
	{
		$result = 0;
		if(String::StartWith(strtoupper($sql), "INSERT"))
			$result = mysql_insert_id();
		else if(String::StartWith(strtoupper($sql), "UPDATE") || String::StartWith(strtoupper($sql), "DELETE"))
			$result = mysql_affected_rows();
		else
		{
			$result = mysql_insert_id();
			if(!isset($result))
			{
				$result = mysql_affected_rows();	
			}
		}		
		return $result;	
	}

	public function ExecScalar($sql)
	{
		$DB_HOST			=		Configuration::$DB_HOST;
		$DB_USER				=		Configuration::$DB_USER;
		$DB_PASSWORD	=		Configuration::$DB_PASSWORD;
		$DB_NAME			=		Configuration::$DB_NAME;
		$conn					=		mysql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
		
		mysql_select_db($DB_NAME,$conn);
		mysql_query("SET NAMES UTF8");
		date_default_timezone_set(Configuration::$TIMEZONE);
		
		$result = mysql_query($sql, $conn) or die ('ERROR: '.$sql.' : '.mysql_error());
		$data = mysql_fetch_assoc($result);

		$value = NULL;
		if ($data != 0)
		{
			if (!empty($data))
			{
				$value = $data[Key($data)];
			}
		}
		mysql_close($conn);
		return $value;	
	}

	public function ExecQuery($sql, $get_direct_mysql_result=false)
	{
		$DB_HOST				=		Configuration::$DB_HOST;
		$DB_USER					=		Configuration::$DB_USER;
		$DB_PASSWORD		=		Configuration::$DB_PASSWORD;
		$DB_NAME				=		Configuration::$DB_NAME;
		$conn						=		mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
		
		mysql_select_db($DB_NAME, $conn);
		mysql_query("SET NAMES UTF8");
		date_default_timezone_set(Configuration::$TIMEZONE);

		$result = mysql_query($sql, $conn) or die ('ERROR: '.$sql.' : '.mysql_error());
		
		if($get_direct_mysql_result)
		{
			mysql_close($conn);
			return $result;	
		}
		else
		{
			
			$data = null;
			if (!empty($result))
			{
				while($row=mysql_fetch_assoc($result))
				{
					$data[] = $row;
				}
			}

			mysql_close($conn);
			return $data;
		}
	}
	

	public function GetCurrentDate()
	{
		return $this->ExecScalar("SELECT DATE_FORMAT(Now(), '%Y-%m-%d %H:%i:%s') AS NOW_DATE");
	}


}
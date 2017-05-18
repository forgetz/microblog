<?php //namespace Code\Logging;

require_once("Core.Configuration.php");

//use Code\Configuration as Configuration;

class LogWriter
{
	public $_file_name="";
	function __construct($file_name) {
		$_file_name = $file_name;
	}
	
	public static function Instance($file_name)
	{
		return new LogWriter($file_name);	
	}
	
	public function WriteLog($ErrorMessage)
	{
		$logFile = $_file_name;
		$file = fopen($logFile, 'a');

		/*$datetime=new DateTime(); */
		//	fwrite($file, "Logging date:".$datetime->format('YmdHis'));
		/*fwrite($file, "\r\n\r\n------ Error Message ---------- \r\n");*/
		//fwrite($file, "-------------------------------------------\r\n\r\n");
		fwrite($file, $ErrorMessage);
		fclose($file); 

	}
	
}


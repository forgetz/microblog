<?php  //namespace Core\Database;
require_once(realpath(dirname(__FILE__))."/Core.Http.php");
require_once(realpath(dirname(__FILE__))."/Core.Database.MySQL.php");

class SubmitForm
{
	public static function Instance()
	{
		return new SubmitForm();	
	}
	
	function SubmitDataPOST($table_name)
	{
		if (empty($table_name))
			return null;

		$MySQL = new MySQL();
		$sql = 'SHOW COLUMNS FROM '.$table_name;
		$data = $MySQL->ExecQuery($sql);
		
		$primary_key_field = null;
		$fields_name = array();
		$fields_value = array();

		foreach ($data as $key=> $value)
		{
			if ($value["Key"])
				$primary_key_field = $value["Field"];
			$fields_name[$key] = $value["Field"];
		}

		foreach ($fields_name as $key=> $value)
		{
			if (Http::IsExistingHttpPost($fields_name[$key]))
				$fields_value[$fields_name[$key]] = Http::GetHttpPost($fields_name[$key]);
		}
		
		if (empty($fields_value[$primary_key_field]))
			$sqlAction = $this->GenerateAddSQL($table_name, $fields_value);
		else
			$sqlAction = $this->GenerateUpdateSQL($table_name, $fields_value, $primary_key_field);

		$data = $MySQL->ExecNonQuery($sqlAction);
	}

	public function GenerateAddSQL($table_name, $fields_value)
	{
		if (empty($table_name))
			return null;
		if (!is_array($fields_value))
			return null;
		
		$sql = 'INSERT INTO '.$table_name.' (';
		$count = 0;
		foreach ($fields_value as $key=> $value)
		{
			if ($count == 0)
				$sql .= $key;
			else
				$sql .= ',' . $key;
			$count++;
		}
		$count = 0;
		$sql .= ') VALUES (';
		foreach ($fields_value as $key=> $value)
		{
			if ($key == $primary_key_field)
				continue;
			if ($count == 0)
				$sql .= '\''.$value.'\'';
			else
				$sql .= ',' . '\''.$value.'\'';
			$count++;
		}
		$sql .= ');';

		return $sql;
	}

	public function GenerateUpdateSQL($table_name, $fields_value, $primary_key_field)
	{
		if (empty($table_name))
			return null;
		if (!is_array($fields_value))
			return null;

		$sql = 'UPDATE '.$table_name.' SET ';
		$count = 0;
		foreach ($fields_value as $key=> $value)
		{
			if ($key == $primary_key_field)
				continue;
			if ($count == 0)
				$sql .= $key . ' = \''.$value.'\'';
			else
				$sql .= ',' . $key . ' = \''.$value.'\'';
			$count++;
		}

		$sql .= ' WHERE '.$primary_key_field.' = \''.$fields_value[$primary_key_field].'\';';

		return $sql;
	}

}
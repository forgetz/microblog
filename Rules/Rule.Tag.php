<?php
require_once(realpath(dirname(__FILE__))."/../Core/Core.Database.MySQL.php");
require_once(realpath(dirname(__FILE__))."/../Core/Core.String.php");
require_once(realpath(dirname(__FILE__))."/../Core/Core.Consts.DbStatus.php");
 
class TagBiz
{
	public static function Instance()
	{
		return new TagBiz();
	}
	
	public function AddTag($name, $status, $created_by)
	{
		$DB = MySQL::Instance();
		$sql = "INSERT INTO tag (NAME, STATUS, CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY) 
					VALUES ('$name', $status, NOW(), $created_by, NOW(), $created_by)";
		return $DB->ExecNonQuery($sql);
	}

	public function UpdateTag($id, $name, $updated_by)
	{
		$DB = MySQL::Instance();
		$sql = "
			UPDATE tag SET
				NAME = '$name' 
				,	UPDATED_DATE = NOW()
				,	UPDATED_BY = $updated_by 
			WHERE id = '$id'
			";
		return $DB->ExecNonQuery($sql);
	}

	public function GetList($Page, $RowPerPage)
	{
		$start_record = ($Page - 1) * $RowPerPage;
		$MySQL = MySQL::Instance();
		$sql = "
				SELECT
					ID, NAME, STATUS, CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY
				FROM tag T
				WHERE 
					status IN (".DbStatus::$PUBLISH.",".DbStatus::$UNPUBLISHED.") 
				ORDER BY NAME ASC
		   		LIMIT $start_record, $RowPerPage
			";

		$data = $MySQL->ExecQuery($sql);
		return $data;
	}

	public function UpdateStatus($id, $status)
	{
		$MySQL = MySQL::Instance();
		$sql = "UPDATE tag SET STATUS = $status WHERE ID = $id";
		$MySQL->ExecNonQuery($sql);
	}

	public function Publish($id)
	{
		return $this->UpdateStatus($id, DbStatus::$PUBLISH);
	}

	public function UnPublish($id)
	{
		return $this->UpdateStatus($id, DbStatus::$UNPUBLISHED);
	}

	public function Delete($id)
	{
		return $this->UpdateStatus($id, DbStatus::$DELETE);
	}



}
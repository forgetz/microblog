<?php
require_once(realpath(dirname(__FILE__))."/../Core/Core.Database.MySQL.php");
require_once(realpath(dirname(__FILE__))."/../Core/Core.String.php");
require_once(realpath(dirname(__FILE__))."/../Core/Core.Consts.DbStatus.php");
 
class ContentBiz
{
	public static function Instance()
	{
		return new ContentBiz();
	}
	
	public function AddContent($title, $description, $is_highlight, $status, $publish_date, $created_date, $created_by)
	{
		$DB = MySQL::Instance();
		$sql = "INSERT INTO content (TITLE, DESCRIPTION, IS_HIGHLIGHT, STATUS, PUBLISH_DATE, CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY) 
					VALUES ('$title', '$description', '$is_highlight', $status, '$publish_date', '$created_date', $created_by, '$created_date', $created_by)";
		return $DB->ExecNonQuery($sql);
	}

	public function UpdateContent($id, $title, $description, $is_highlight, $publish_date, $updated_date, $updated_by)
	{
		$DB = MySQL::Instance();
		$sql = "
			UPDATE content SET
				TITLE							= '$title'
				, DESCRIPTION			= '$description'
				, IS_HIGHLIGHT			= '$is_highlight'
				, PUBLISH_DATE		= '$publish_date'
				, UPDATED_DATE		= '$updated_date'
				, UPDATED_BY			= '$updated_by'
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
					ID, TITLE, DESCRIPTION, IS_HIGHLIGHT, STATUS, PUBLISH_DATE, CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY
				FROM content C
				INNER JOIN users U
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
		$sql = "UPDATE content SET STATUS = $status WHERE ID = $id";
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
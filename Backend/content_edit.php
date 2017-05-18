<?php
	require_once(realpath(dirname(__FILE__))."/../Core/Core.Form.php");
	require_once(realpath(dirname(__FILE__))."/../Core/Core.Database.MySQL.php");
	require_once(realpath(dirname(__FILE__))."/../Core/Core.Http.php");
	require_once(realpath(dirname(__FILE__))."/../Core/Core.SubmitForm.php");
	require_once(realpath(dirname(__FILE__))."/master.php");

	$MasterPage = new MasterPage();
	$Form = new Form();
	$SubmitForm = new SubmitForm(); 

	$MasterPage->WriteHeader();
	$MasterPage->WriteMenu(basename(__FILE__));

	$table_name = "content";

	if (Http::IsPostBack())
	{
		$SubmitForm->SubmitDataPOST($table_name);
		Exit();
	}

	$get_id = Http::GetHttpGet("id");
	if ($get_id > 0)
		$Form->GenerateForm($get_id, $table_name, "UPDATED_DATE, UPDATED_BY", "CREATED_DATE, CREATED_BY");
	else
		$Form->GenerateForm(0, $table_name, "CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY", "ID");
	
	$MasterPage->WriteFooter();
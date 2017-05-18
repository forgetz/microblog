<?php
	require_once(realpath(dirname(__FILE__))."/Core/Core.Form.php");

	if (!empty($_POST["txt_title"]))
	{
		echo "<PRE>";
		print_r($_POST);
		echo "</PRE>";
		Exit();
	}

	$Form = new Form();
	$Form->GenerateForm(0, "content", "ID, CREATED_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY");
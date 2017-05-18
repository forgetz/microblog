<?php
	require_once(realpath(dirname(__FILE__))."/master.php");
	
	$MasterPage = new MasterPage();
	$MasterPage->WriteHeader();
	$MasterPage->WriteMenu(basename(__FILE__));
?>



<?php
	$MasterPage->WriteFooter();

	function Get()
	{
		// GET COLUMNS FROM TABLE
		// GET COLUMNS GENERATE LIST
	}
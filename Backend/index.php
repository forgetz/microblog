<?php
	require_once ("master.php");
	$MasterPage = new MasterPage();
	$MasterPage->WriteHeader();
	$MasterPage->WriteMenu(basename(__FILE__));
?>



<?php
	$MasterPage->WriteFooter();
?>
<?php
	require_once ("master.php");
	$MasterPage = new MasterPage();
	$MasterPage->WriteHeader();
	$MasterPage->WriteMenu("");
?>



<?php
	$MasterPage->WriteFooter();
?>
<?php
	require_once(realpath(dirname(__FILE__))."/../Core/Core.Http.php");
	require_once(realpath(dirname(__FILE__))."/../Core/Core.Configuration.php");
	require_once(realpath(dirname(__FILE__))."/../Rules/Rule.Tag.php");
	require_once(realpath(dirname(__FILE__))."/master.php");
	
	//$TagBiz->AddTag("test", 1, 1);
	//$TagBiz->UpdateTag(1, "abc", 1);
	//$TagBiz->Publish(1);

	$TagBiz = TagBiz::Instance();
	$rows = Configuration::GetConfig("backrows");
	$page = Http::GetHttpGet("page");

	if (empty($page))
		$page = 1;
	if (empty($rows))
		$rows = 10;

	$list = $TagBiz->GetList($page, $rows);

	$MasterPage = new MasterPage();
	$MasterPage->WriteHeader();
	$MasterPage->WriteMenu(basename(__FILE__));
?>



<?php
	$MasterPage->WriteFooter();
?>
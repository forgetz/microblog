<?php

class MasterPage
{
	function WriteHeader()
	{
		echo '
		<!DOCTYPE html>
		<html lang="en">
		  <head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="">
			<meta name="author" content="">
			<link rel="shortcut icon" href="favicon.ico">
			<title>MicroBlog</title>
			<link href="../css/bootstrap.min.css" rel="stylesheet">
			<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
			<link href="../css/theme.css" rel="stylesheet">
			<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		  </head>

		  <body role="document">
		';
	}

	function WriteFooter()
	{
		$year = date("Y");
		echo '
		<footer>
			<hr>
			<p>
				<div id="container" class="text-center">
					Copyright &copy; '.$year.' <a href="http://www.nut.in.th">http://www.nut.in.th</a>
				</div>
			</p>
		</footer>

		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/docs.min.js"></script>

		</body>
		</html>
		';
	}

	function WriteMenu($menu_selected)
	{
		echo '
			<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			  <div class="container">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="index.php">Administartor</a>
				</div>
				<div class="navbar-collapse collapse">
				  <ul class="nav navbar-nav">
					<li class="'.($menu_selected == "content_list.php" || $menu_selected == "content_edit.php" ? "active" : "").'"><a href="content_list.php">Content</a></li>
					<li class="'.($menu_selected == "tag_list.php" || $menu_selected == "tag_edit.php" ? "active" : "").'"><a href="tag_list.php">Tag</a></li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</div>
		';
	}

	function WriteTable($list, $header, $action)
	{
		//if (!is_array($list))
		//	return;
		//if (!is_array($header))
		//	return;
		//if (!is_array($action))
		//	return;
		
		//$bar = ucfirst(strtolower($bar));
		print_r($header);
	}

}
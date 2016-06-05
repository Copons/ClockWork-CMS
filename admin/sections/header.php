<?php

session_start();

require('include/header.inc.php');

clearAdvices();

?>
<!--[if !IE]><!DOCTYPE html><![endif]-->
<!--[if IE]><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><![endif]-->
<html lang="it">
<head>
<meta charset="utf-8" />
<meta name="author" content="Jacopo Tomasone" />
<meta name="copyright" content="H25 Media Agency" />
<title><?php pageTitle($page); ?></title>

<script src="style/jquery-1.6.2.min.js"></script>
<script src="style/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="style/functions.js?rand=<?php echo rand(1,1000); ?>"></script>

<link href="style/normalize.css" rel="stylesheet" type="text/css" media="all" />
<link href="style/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="style/cw3.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="style/fancybox/jquery.fancybox-1.3.4.css" media="all" />

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<!--[if IE]>
	<script src="style/html5.js"></script>
	<script src="style/IE9.js"></script>
<![endif]-->

</head>

<body>

<header id="header" class="clear">
	<h1><img src="images/h25label.png" alt="H25 Media Agency - " /> <?php echo outputString($config['name']); ?></h1>
	<a id="view-site" href="../" target="_blank">View Site  <img src="images/view-site.png" alt="View Site" /></a>
	<div id="user-hello">
		<?php if ($_COOKIE['login'] == 'ok') : ?>
		Hi, <?php echo strtoupper($_COOKIE['username']); ?>
		<a id="logout" href="pages/login/logout.php">Logout</a>
		<?php endif; ?>
	</div>
</header>

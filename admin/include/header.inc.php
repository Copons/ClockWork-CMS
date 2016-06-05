<?php

require('include/config.inc.php');
require('include/errors.inc.php');

require('functions/mysql.php');
MySQLconnectW();

require('include/info.inc.php');
require('functions/support.php');
require('functions/advices.php');
require('functions/login.php');
require('functions/strings.php');
require('functions/upload.php');
require('functions/log.php');

if (!isset($_REQUEST['action']))
	require('functions/viewTable.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'insert')
	require('functions/insertTable.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'single')
	require('functions/singleTable.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	require('functions/editTable.php');

if ($page != "login")
	checkLogin();

?>
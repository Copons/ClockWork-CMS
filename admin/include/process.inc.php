<?php

session_start();

require('../../include/config.inc.php');
require('../../include/errors.inc.php');

require('../../functions/mysql.php');
MySQLconnectW();

require('../../include/info.inc.php');
require('../../functions/support.php');
require('../../functions/advices.php');
require('../../functions/login.php');
require('../../functions/strings.php');
require('../../functions/upload.php');

require('../../functions/process.php');
require('../../functions/log.php');

if (!isset($noCheckLogin))
	checkLogin();

?>
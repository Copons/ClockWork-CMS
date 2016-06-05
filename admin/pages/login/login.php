<?php

$noCheckLogin = TRUE;

require("../../include/process.inc.php");

$query = "SELECT 
	id, username, role 
FROM 
	".PREFIX."admin 
WHERE 
	username = '" . cleanString($_REQUEST['username']) . "' AND 
	password = '" . md5(cleanString($_REQUEST['password'])) . "' 
LIMIT 1";
$result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($result) == 0) :
	setError('wrong_login');
	failedLogin();
	redirect('../../index.php');
else :
	$row = mysql_fetch_assoc($result);
	okLogin($row);
	redirect('../../home.php');
endif;

?>
<?php

/*
MySQLconnectR ()
MySQLconnectW ()
*/




// MySQL READING CONNECTION
//
// MySQL database connection with reading permissions
function MySQLconnectR () {
	global $DBcfg;
	$link = mysql_connect($DBcfg['host'], $DBcfg['user_r'], $DBcfg['password_r']);
	if (!$link)
		die($ERROR['mysql_connect']);
	if (!mysql_select_db($DBcfg['dbname']))
		die($ERROR['mysql_database']);
}




// MySQL WRITING CONNECTION
//
// MySQL database connection with writing permissions
function MySQLconnectW () {
	global $DBcfg;
	$link = mysql_connect($DBcfg['host'], $DBcfg['user_w'], $DBcfg['password_w']);
	if (!$link)
		die($ERROR['mysql_connect']);
	if (!mysql_select_db($DBcfg['dbname']))
		die($ERROR['mysql_database']);
}

?>
<?php

try {
	$DBH = new PDO('mysql:host='.$DBcfg['host'].';dbname='.$DBcfg['dbname'], $DBcfg['user_w'], $DBcfg['password_w']);
	$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $DBH;
}
catch (PDOException $e) {
	echo $e->getMessage();
}
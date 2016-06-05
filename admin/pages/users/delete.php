<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$title = deleteQuery('users', 'username', $_REQUEST['ID']);
	insertLogRecord('users', 'delete', $_REQUEST['ID'], $title);
	setOk('User <strong>' . $title . '</strong> deleted.');
	redirect('../../users.php');

endif;

?>

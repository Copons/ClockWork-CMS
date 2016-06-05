<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$title = deleteQuery('admin', 'username', $_REQUEST['ID']);
	insertLogRecord('admin', 'delete', $_REQUEST['ID'], $title);
	setOk('Administrator <strong>' . $title . '</strong> deleted.');
	redirect('../../admin.php');

endif;

?>

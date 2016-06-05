<?php

require('../../include/process.inc.php');

checkLevel('admin,supervisor', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	decrementPosition('articles', 'page', $_REQUEST['ID']);

	$title = deleteQuery('articles', 'title', $_REQUEST['ID']);

	insertLogRecord('pages', 'delete', $_REQUEST['ID'], $title);

	setOk('Page <strong>' . $title . '</strong> deleted.');

	redirect('../../pages.php');

endif;

?>

<?php

require('../../include/process.inc.php');

checkLevel('admin,supervisor', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$img = deleteFile ('news', '', 'articles', 'featured_image');
	deleteFile('news', '300x150-'.$img);

	$title = deleteQuery('articles', 'title', $_REQUEST['ID']);

	insertLogRecord('news', 'delete', $_REQUEST['ID'], $title);

	setOk('News <strong>' . $title . '</strong> deleted.');

	redirect('../../news.php');

endif;

?>

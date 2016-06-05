<?php

require('../../include/process.inc.php');

checkLevel('admin,supervisor', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	decrementPosition('articles', 'featured', $_REQUEST['ID']);

	$img = deleteFile ('featured', '', 'articles', 'featured_image');
	deleteFile('featured', '150x150-'.$img);
	deleteFile('featured', '1280x720-'.$img);

	$title = deleteQuery('articles', 'title', $_REQUEST['ID']);

	insertLogRecord('featured', 'delete', $_REQUEST['ID'], $title);

	setOk('Featured element <strong>' . $title . '</strong> deleted.');

	redirect('../../featured.php');

endif;

?>

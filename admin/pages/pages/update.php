<?php

require('../../include/process.inc.php');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array(
		'title' 			=> 'clean',
		'subtitle'			=> 'clean',
		'content'			=> 'addslashes',
		'parent'			=> 'clean',
		'position'			=> 'clean',
		'seo_description'	=> 'clean',
		'meta_special'		=> 'clean',
		'status'			=> 'clean'
	);
	$fields = fieldsToArray($arrayFields);




	if (
		$fields['title']	== '' ||
		$fields['position']	== '') :

		setError('required_fields');
		redirect('../../pages.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		$fields['type'] = 'page';
		if ($fields['status'] == '') $fields['status'] = 'draft';

		$fields['position'] = updatePosition('articles', 'page', $_REQUEST['ID'], $fields['position']);

		updateQuery('articles', $fields, $_REQUEST['ID']);

		insertLogRecord('pages', 'update', $_REQUEST['ID'], $fields['title']);

		setOk('Page <strong>' . $fields['title'] . '</strong> updated.');

		redirect('../../pages.php');

	endif;

endif;

?>

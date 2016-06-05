<?php

require('../../include/process.inc.php');

$arrayFields = array(
	'title' 			=> 'clean',
	'subtitle'			=> 'clean',
	'content' 			=> 'addslashes',
	'parent'			=> 'clean',
	'position'			=> 'clean',
	'meta_special'		=> 'clean',
	'seo_description'	=> 'clean',
	'status'			=> 'clean'
);
$fields = fieldsToArray($arrayFields);




if (
	$fields['title'] 	== '' ||
	$fields['position']	== '') :

	rememberFields('pages', $fields);
	setError('required_fields');
	redirect('../../pages.php?action=insert');

else :

	rememberFields('pages', $fields);

	incrementPosition('articles', 'page', $fields['position']);

	$fields['type'] = 'page';
	if ($fields['status'] == '') $fields['status'] = 'draft';

	$insertId = insertQuery('articles', $fields);

	insertLogRecord('pages', 'save', $insertId, $fields['title']);

	forgetFields('pages', $fields);

	setOk('Page <strong>' . $fields['title'] . '</strong> created.');

	redirect('../../pages.php');

endif;

?>

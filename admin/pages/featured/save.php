<?php

require('../../include/process.inc.php');

$arrayFields = array(
	'title' 			=> 'clean',
	'subtitle'			=> 'clean',
	'excerpt'			=> 'clean',
	'meta_page'			=> 'clean',
	'position'			=> 'clean',
	'status'			=> 'clean'
);
$fields = fieldsToArray($arrayFields);

//var_dump($_FILES); die();

if (
	$fields['title'] 			== '' &&
	$fields['position']			== '') :

	rememberFields('featured', $fields);
	setError('required_fields');
	redirect('../../featured.php?action=insert');

else :

	rememberFields('featured', $fields);

	$fields['type'] = 'featured';
	if ($fields['status'] == '') $fields['status'] = 'draft';

	$fields['featured_image'] = insertImage('featured', 'featured_image', time().'-'.$fields['title']);
	$crop = cwImageCrop($fields['featured_image'], 'featured', 150, 150);
	$crop2 = cwImageCrop($fields['featured_image'], 'featured', 1280, 720);

	incrementPosition('articles', 'featured', $fields['position']);

	$insertId = insertQuery('articles', $fields);

	insertLogRecord('featured', 'save', $insertId, $fields['title']);

	forgetFields('featured', $fields);

	setOk('Featured element <strong>' . $fields['title'] . '</strong> created.');

	redirect('../../featured.php');

endif;

?>

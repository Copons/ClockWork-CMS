<?php

require('../../include/process.inc.php');

$arrayFields = array(
	'title' 			=> 'clean',
	'date_publishedDay'	=> 'date',
	'date_publishedMonth'=> 'date',
	'date_publishedYear'=> 'date',
	'excerpt'			=> 'clean',
	'content' 			=> 'addslashes',
	'seo_description'	=> 'clean',
	'status'			=> 'clean'
);
$fields = fieldsToArray($arrayFields);

//var_dump($_FILES); die();

if (
	$fields['title'] 			== '' ||
	$fields['date_published']	== '0000-00-00') :

	rememberFields('news', $fields);
	setError('required_fields');
	redirect('../../news.php?action=insert');

else :

	rememberFields('news', $fields);

	$fields['type'] = 'news';
	if ($fields['status'] == '') $fields['status'] = 'draft';

	$fields['featured_image'] = insertImage('news', 'featured_image', time().'-'.$fields['title']);
	$crop = cwImageCrop($fields['featured_image'], 'news', 300, 150);

	$insertId = insertQuery('articles', $fields);

	insertLogRecord('news', 'save', $insertId, $fields['title']);

	forgetFields('news', $fields);

	setOk('News <strong>' . $fields['title'] . '</strong> created.');

	redirect('../../news.php');

endif;

?>

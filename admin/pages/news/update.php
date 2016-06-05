<?php

require('../../include/process.inc.php');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array(
		'title' 			=> 'clean',
		'date_publishedDay'	=> 'date',
		'date_publishedMonth'=> 'date',
		'date_publishedYear'=> 'date',
		'excerpt'			=> 'clean',
		'content'			=> 'addslashes',
		'seo_description'	=> 'clean',
		'status'			=> 'clean'
	);
	$fields = fieldsToArray($arrayFields);




	if (
		$fields['title']			== '' ||
		$fields['date_published']	== '0000-00-00') :

		setError('required_fields');
		redirect('../../news.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		if (isset($_REQUEST['delete_featured_image'])) :
			deleteFile('news', cleanString($_REQUEST['delete_featured_image']), 'articles');
			deleteFile('news', '300x150-'.cleanString($_REQUEST['delete_featured_image']), 'articles');
			$fields['featured_image'] = '';
		else :
			$fields['featured_image'] = editImage('news', 'featured_image', $_REQUEST['ID'], time().'-'.$fields['title'], array(300 => 150), 'articles');
			$crop = cwImageCrop($fields['featured_image'], 'news', 300, 150);
		endif;

		$fields['type'] = 'news';
		if ($fields['status'] == '') $fields['status'] = 'draft';

		updateQuery('articles', $fields, $_REQUEST['ID']);

		insertLogRecord('news', 'update', $_REQUEST['ID'], $fields['title']);

		setOk('News <strong>' . $fields['title'] . '</strong> updated.');

		redirect('../../news.php');

	endif;

endif;

?>

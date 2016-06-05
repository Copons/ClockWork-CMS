<?php

require('../../include/process.inc.php');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array(
		'title' 			=> 'clean',
		'subtitle'			=> 'clean',
		'excerpt'			=> 'clean',
		'meta_page'			=> 'clean',
		'position'			=> 'clean',
		'status'			=> 'clean'
	);
	$fields = fieldsToArray($arrayFields);




	if (
		$fields['title'] 			== '' &&
		$fields['position']			== '') :

		setError('required_fields');
		redirect('../../featured.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		if (isset($_REQUEST['delete_featured_image'])) :
			deleteFile('featured', cleanString($_REQUEST['delete_featured_image']), 'articles');
			deleteFile('featured', '150x150-'.cleanString($_REQUEST['delete_featured_image']), 'articles');
			deleteFile('featured', '1280x720-'.cleanString($_REQUEST['delete_featured_image']), 'articles');
			$fields['featured_image'] = '';
		else :
			$fields['featured_image'] = editImage('featured', 'featured_image', $_REQUEST['ID'], time().'-'.$fields['title'], array(150 => 150, 1280 => 720), 'articles');
			$crop = cwImageCrop($fields['featured_image'], 'featured', 150, 150);
			$crop2 = cwImageCrop($fields['featured_image'], 'featured', 1280, 720);
		endif;

		$fields['type'] = 'featured';
		if ($fields['status'] == '') $fields['status'] = 'draft';

		$fields['position'] = updatePosition('articles', 'featured', $_REQUEST['ID'], $fields['position']);

		updateQuery('articles', $fields, $_REQUEST['ID']);

		insertLogRecord('featured', 'update', $_REQUEST['ID'], $fields['title']);

		setOk('Featured Element <strong>' . $fields['title'] . '</strong> updated.');

		redirect('../../featured.php');

	endif;

endif;

?>

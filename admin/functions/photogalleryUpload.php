<?php

session_start();

require('../include/config.inc.php');
require('../include/errors.inc.php');

require('../functions/mysql.php');
MySQLconnectW();

require('../include/info.inc.php');
require('../functions/support.php');
require('../functions/advices.php');
require('../functions/login.php');
require('../functions/strings.php');
require('../functions/upload.php');

require('../functions/process.php');
require('../functions/log.php');

if (!isset($noCheckLogin))
	checkLogin();

if (checkIdInline($_REQUEST['ID'])) :

	if (!isset($_REQUEST['action']) ||
		($_REQUEST['action'] != 'upload' &&
		$_REQUEST['action'] != 'update' &&
		$_REQUEST['action'] != 'delete')) :
		redirect('photogallery.php?pageID='.$_REQUEST['ID']);
	endif;
	if ($_FILES['upload']['error'] == 4) :
		redirect('photogallery.php?pageID='.$_REQUEST['ID']);
	endif;


	if ($_REQUEST['action'] == 'upload') :

		if ($_REQUEST['title'] == '') :
			$title = $_FILES['upload']['name'];
		else :
			$title = cleanString($_REQUEST['title']);
		endif;

		$fields['upload'] = photogalleryUpload ($_FILES['upload']);
		$crop1 = cwImageCrop($fields['upload'], 'photogallery', 150, 150, true);
		$crop2 = cwImageCrop($fields['upload'], 'photogallery', 300, 300, true);
		$crop3 = cwImageCrop($fields['upload'], 'photogallery', 500, 500, true);

		incrementPosition ('articles', 'photogallery', cleanString($_REQUEST['position']));

		$q = 'INSERT INTO '.PREFIX.'articles (
			title,
			type,
			parent,
			position,
			featured_image,
			date_modified,
			editor,
			status
		) VALUES (
			"'.$title.'",
			"photogallery",
			"'.cleanString($_REQUEST['ID']).'",
			"'.cleanString($_REQUEST['position']).'",
			"'.$fields['upload'].'",
			NOW(),
			"'.$_COOKIE['userid'].'",
			"published"
		)';
		//echo $q; die();
		$r = mysql_query($q) or die(mysql_error());

	elseif ($_REQUEST['action'] == 'update') :

		//var_dump($_REQUEST); die();

		$pos = updatePosition ('articles', 'photogallery', cleanString($_REQUEST['pic']), cleanString($_REQUEST['position']));

		$q = 'UPDATE '.PREFIX.'articles SET title = "'.cleanString($_REQUEST['title']).'", position = "'.cleanString($pos).'" WHERE id = "'.cleanString($_REQUEST['pic']).'"';
		$r = mysql_query($q) or die(mysql_error());

	elseif ($_REQUEST['action'] == 'delete') :

		$queryImage = 'SELECT parent, position, featured_image FROM '.PREFIX.'articles WHERE id = "'.cleanString($_REQUEST['pic']).'"';
		$resultImage = mysql_query($queryImage) or die(mysql_error());
		$rowImage = mysql_fetch_assoc($resultImage);
		if (is_file('../../uploads/photogallery/' . $rowImage['featured_image'])) :
			unlink('../../uploads/photogallery/' . $rowImage['featured_image']);
			unlink('../../uploads/photogallery/150x150-' . $rowImage['featured_image']);
			unlink('../../uploads/photogallery/300x300-' . $rowImage['featured_image']);
			unlink('../../uploads/photogallery/500x500-' . $rowImage['featured_image']);
		endif;

		$query = 'UPDATE '.PREFIX.'articles SET position = position - 1 WHERE type = "photogallery" AND position > "' . $rowImage['position'] . '" ORDER BY position ASC';
		$result = mysql_query($query) or die(mysql_error());
	
		$q = 'DELETE FROM '.PREFIX.'articles WHERE id = "'.cleanString($_REQUEST['pic']).'" LIMIT 1';
		$r = mysql_query($q) or die(mysql_error());

	endif;

	redirect('photogallery.php?pageID='.$_REQUEST['ID']);

endif;
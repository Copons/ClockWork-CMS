<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "page" LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The page does not exist.');
	else :

		require('pages/pages/array.php');

		$query = 'SELECT * FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "page" LIMIT 1';
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		echo '<div id="ajax-data" data-page="pages" data-item="' . $_REQUEST['ID'] . '"></div>';

		editHeader		('pages', 'page', $row['id'], $row['title']);

		editInput		('title', 'Title', $row['title'], '', '*', 'text', '50', '255', TRUE);

		editInput		('subtitle', 'Subtitle', $row['subtitle'], '', '', 'text', '80', '255');

		editTextarea	('content', 'Content', $row['content'], '', '', '70', '6');

		editSelect		('parent', 'Sub-page of', $row['parent'], '', '', $arrayPagesSelect);



$position = -1;
$curr_where = '';
$qcurr = 'SELECT position FROM '.PREFIX.'articles WHERE id = "'.cleanString($_REQUEST['ID']).'" LIMIT 1';
$rcurr = mysql_query($qcurr) or die(mysql_error());
if (mysql_num_rows($rcurr) == 1) :
	$curr = mysql_fetch_assoc($rcurr);
	if ($curr['position'] != '' && $curr['position'] > 0) :
		$curr_where = ' id != "'.cleanString($_REQUEST['ID']).'" AND ';
		$position = $curr['position'];
	endif;
endif;


$arrayPosition = array();
$qPos = 'SELECT
	position, title
FROM
	'.PREFIX.'articles
WHERE
	'.$curr_where.'
	type = "page" AND
	parent = "'.cleanString($row['parent']).'"
ORDER BY position ASC';
$rPos = mysql_query($qPos) or die(mysql_error());
if (mysql_num_rows($rPos) == 0) :
	$qtot = 'SELECT id FROM '.PREFIX.'articles WHERE type = "page"';
	$rtot = mysql_query($qtot) or die(mysql_error());
	$tot = mysql_num_rows($rtot);
	$arrayPosition[$tot+1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;


		editSelect		('position', 'Position', $row['position']+1, '', '*', $arrayPosition);

		$qmeta = 'SELECT meta_value FROM '.PREFIX.'meta WHERE article = "'.$row['id'].'" AND meta_key = "page_special" LIMIT 1';
		$rmeta = mysql_query($qmeta) or die(mysql_error());
		$meta = mysql_fetch_assoc($rmeta);
		editSelect		('meta_special', 'Special Page', $meta['meta_value'], '', '', $arraySpecial);

		editInput		('seo_description', 'Meta Description', $row['seo_description'], '(Max 160 characters)', '', 'text', '80', '160');

		if(checkLevel('admin,supervisor', 'item'))
			editSelect	('status', 'Status', $row['status'], '', '', $arrayStatus);

		editGallery		($row['id']);

		editSave		('pages', $row['id'], $row['title'], 'admin,supervisor');

		editFooter		();

	endif;

endif;

?>

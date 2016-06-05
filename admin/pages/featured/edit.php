<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "featured" LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The featured element does not exist.');
	else :

		require('pages/pages/array.php');
		require('pages/featured/array.php');

		$query = 'SELECT * FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "featured" LIMIT 1';
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		echo '<div id="ajax-data" data-page="featured" data-item="' . $_REQUEST['ID'] . '"></div>';

		editHeader		('featured', 'featured', $row['id'], $row['title']);

		editInput		('title', 'Title', $row['title'], '', '*', 'text', '50', '255', TRUE);

		editInput		('subtitle', 'Subtitle', $row['subtitle'], '', '', 'text', '80', '255');

		editInput		('excerpt', 'Excerpt', $row['excerpt'], '', '', 'text', '80', '255');

		editImage		('featured_image', 'Upload &frasl; Replace Image', '(Only image files - max 500 KB)', '', '2000000', 'featured', $row['featured_image'], 100, 0);

		$qmeta = 'SELECT meta_value FROM '.PREFIX.'meta WHERE article = "'.$row['id'].'" AND meta_key = "featured_page" LIMIT 1';
		$rmeta = mysql_query($qmeta) or die(mysql_error());
		$meta2 = mysql_fetch_assoc($rmeta);
		editSelect		('meta_page', 'Featured Page', $meta2['meta_value'], '', '', $arrayPagesSelect);



$position = -1;
$curr_where = '';
$qcurr = 'SELECT position FROM '.PREFIX.'articles WHERE id = "'.cleanString($_REQUEST['ID']).'" LIMIT 1';
$rcurr = mysql_query($qcurr) or die(mysql_error());
if (mysql_num_rows($rcurr) == 1) :
	$curr = mysql_fetch_assoc($rcurr);
	if ($curr['position'] != '' && $curr['position'] > 0) :
		$curr_where = ' a.id != "'.cleanString($_REQUEST['ID']).'" AND ';
		$position = $curr['position'];
	endif;
endif;


$arrayPosition = array();
$qPos = 'SELECT
	a.position AS position,
	a.title AS title
FROM
	'.PREFIX.'articles AS a
WHERE
	'.$curr_where.'
	a.type = "featured"
ORDER BY a.position ASC';
$rPos = mysql_query($qPos) or die(mysql_error());
if (mysql_num_rows($rPos) == 0) :
	$arrayPosition[1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;
if (count($arrayPosition) == $row['position']) :
	$position = count($arrayPosition);
else :
	$position = $row['position']+1;
endif;


		editSelect		('position', 'Position', $position, '', '*', $arrayPosition);

		if(checkLevel('admin,supervisor', 'item'))
			editSelect	('status', 'Status', $row['status'], '', '', $arrayStatus);

		editSave		('featured', $row['id'], $row['title'], 'admin,supervisor');

		editFooter		();

	endif;

endif;

?>

<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "news" LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The news does not exist.');
	else :

		require('pages/news/array.php');

		$query = 'SELECT * FROM '.PREFIX.'articles WHERE id = ' . $_REQUEST['ID'] . ' AND type = "news" LIMIT 1';
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		echo '<div id="ajax-data" data-page="news" data-item="' . $_REQUEST['ID'] . '"></div>';

		editHeader		('news', 'news', $row['id'], $row['title']);

		editInput		('title', 'Title', $row['title'], '', '*', 'text', '50', '255', TRUE);

		editDate		('date_published', 'Date', $row['date_published'], '', '*', '', '');

		editInput		('excerpt', 'Excerpt', $row['excerpt'], '', '', 'text', '80', '255');

		editTextarea	('content', 'Content', $row['content'], '', '', '70', '6');

		editImage		('featured_image', 'Upload &frasl; Replace Imae', '(Only image files - max 500 KB)', '', '2000000', 'news', $row['featured_image'], 100, 0);

		editInput		('seo_description', 'Meta Description', $row['seo_description'], '(Max 160 characters)', '', 'text', '80', '160');

		if(checkLevel('admin,supervisor', 'item'))
			editSelect	('status', 'Status', $row['status'], '', '', $arrayStatus);

		editGallery		($row['id']);

		editSave		('news', $row['id'], $row['title'], 'admin,supervisor');

		editFooter		();

	endif;

endif;

?>

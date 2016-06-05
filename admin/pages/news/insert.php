<?php

	require('pages/news/array.php');

	echo '<div id="ajax-data" data-page="news" data-item=""></div>';

	insertHeader	('news', 'Create a news &raquo;');

	insertInput		('title', 'Title', '', '*', 'text', '50', '255', 'news', TRUE);

	insertDate		('date_published', 'Date', '', '*', '', '', 'news');

	insertInput		('excerpt', 'Excerpt', '', '', 'text', '80', '255', 'news');

	insertTextarea	('content', 'Content', '', '', '70', '6', 'news');

	insertFile		('featured_image', 'Upload Image', '(Only image files - max 500 KB)', '', '2000000');

	insertInput		('seo_description', 'Meta Description', '(Max 160 characters)', '', 'text', '80', '160', 'news');

	if(checkLevel('admin,supervisor', 'item'))
		insertSelect('status', 'Status', '', '', $arrayStatus, 'news');

	insertSave		();

	insertFooter	();

?>

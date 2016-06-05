<?php

	require('pages/pages/array.php');
	require('pages/featured/array.php');

	echo '<div id="ajax-data" data-page="featured" data-item=""></div>';

	insertHeader	('featured', 'Create a new featured element &raquo;');

	insertInput		('title', 'Title', '', '*', 'text', '50', '255', 'featured', TRUE);

	insertInput		('subtitle', 'Subtitle', '', '', 'text', '80', '255', 'featured');

	insertInput		('excerpt', 'Excerpt', '', '', 'text', '80', '255', 'featured');

	insertFile		('featured_image', 'Upload Image', '(Only image files - max 500 KB)', '', '2000000');

	insertSelect	('meta_page', 'Featured Page', '', '', $arrayPagesSelect, 'featured');

	insertSelect	('position', 'Position', '', '*', $arrayPosition, 'featured');

	if(checkLevel('admin,supervisor', 'item'))
		insertSelect('status', 'Status', '', '', $arrayStatus, 'featured');

	insertSave		();

	insertFooter	();

?>

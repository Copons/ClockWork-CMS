<?php

	require('pages/pages/array.php');

	echo '<div id="ajax-data" data-page="pages" data-item=""></div>';

	insertHeader	('pages', 'Create a new page &raquo;');

	insertInput		('title', 'Title', '', '*', 'text', '50', '255', 'pages', TRUE);

	insertInput		('subtitle', 'Subtitle', '', '', 'text', '80', '255', 'pages');

	insertTextarea	('content', 'Content', '', '', '70', '6', 'pages');

	insertSelect	('parent', 'Sub-page of', '', '', $arrayPagesSelect, 'pages');

	insertSelect	('position', 'Posizione', '', '*', $arrayPosition, 'pages');

	insertSelect	('meta_special', 'Pagina Speciale', '', '', $arraySpecial, 'pages');

	insertInput		('seo_description', 'Meta Description', '(Massimo 160 caratteri)', '', 'text', '80', '160', 'pages');

	if(checkLevel('admin,supervisor', 'item'))
		insertSelect('status', 'Status', '', '', $arrayStatus, 'pages');

	insertSave		();

	insertFooter	();

?>

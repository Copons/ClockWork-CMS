<?php

	require('pages/admin/array.php');

	insertHeader	('admin', 'Create a new administrator &raquo;');

	insertInput		('username', 'Username', '', '*', 'text', '30', '255', 'admin', TRUE);
	insertInput		('password', 'Password', '', '*', 'password', '30', '255', 'admin');
	insertInput		('password2', 'Type the password again', '', '*', 'password', '30', '255', 'admin');
	insertSelect	('role', 'Role', '', '*', $arrayLivelli, 'admin');
	insertInput		('email', 'Email', '', '*', 'text', '30', '255', 'admin');
	insertInput		('description', 'Description', '', '', 'text', '70', '255', 'admin');
	insertSave		();

	insertFooter	();

?>

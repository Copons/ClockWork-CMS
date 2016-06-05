<?php

	require('pages/users/array.php');

	insertHeader	('users', 'Create a new user &raquo;');

	insertInput		('email', 'Email', '', '*', 'text', '30', '255', 'users', TRUE);
	insertInput		('password', 'Password', '', '*', 'password', '30', '255', 'users');
	insertInput		('password2', 'Type the password again', '', '*', 'password', '30', '255', 'users');
	insertSelect	('status', 'Status', '', '', $arrayStatus, 'users');
	insertSave		();

	insertFooter	();

?>

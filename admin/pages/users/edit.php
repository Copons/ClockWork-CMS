<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'users WHERE id = ' . $_REQUEST['ID'] . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The user does not exist.');
	else :

		require('pages/users/array.php');

		$query = 'SELECT * FROM '.PREFIX.'users WHERE id = ' . $_REQUEST['ID'];
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		editHeader		('users', 'user', $row['id'], $row['email']);

		editInput		('email', 'Email', $row['email'], '', '*', 'text', '30', '255', TRUE);
		editInput		('password', 'Password', '', '', '', 'password', '30', '255');
		editInput		('password2', 'Type the password again', '', '', '', 'password', '30', '255');
		editSelect		('status', 'Status', $row['status'], '', '', $arrayStatus);
		editSave		('users', $row['id'], $row['username']);

		editFooter		();

	endif;

endif;

?>

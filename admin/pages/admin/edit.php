<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'admin WHERE id = ' . $_REQUEST['ID'] . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The administrator does not exist.');
	else :

		require('pages/admin/array.php');

		$query = 'SELECT * FROM '.PREFIX.'admin WHERE id = ' . $_REQUEST['ID'];
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		editHeader		('admin', 'administrator', $row['id'], $row['nickname']);

		editInput		('username', 'Username', $row['username'], '', '*', 'text', '30', '255', TRUE);
		editInput		('password', 'Password', '', '', '', 'password', '30', '255');
		editInput		('password2', 'Type the password again', '', '', '', 'password', '30', '255');
		editSelect		('role', 'Role', $row['role'], '', '*', $arrayLivelli);
		editInput		('email', 'Email', $row['email'], '', '*', 'text', '30', '255');
		editInput		('description', 'Description', $row['description'], '', '', 'text', '70', '255');
		editSave		('admin', $row['id'], $row['username']);

		editFooter		();

	endif;

endif;

?>

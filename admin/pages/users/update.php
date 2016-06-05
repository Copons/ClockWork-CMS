<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array(
		'email'			=> 'clean',
		'password'		=> 'password',
		'password2'		=> 'password',
		'first_name'	=> 'clean',
		'family_name'	=> 'clean',
		'degree'		=> 'clean',
		'status'		=> 'clean'
	);
	$fields = fieldsToArray($arrayFields);




	if ($fields['email'] == '') :

		setError('required_fields');
		redirect('../../users.php?action=edit&ID=' . $_REQUEST['ID']);

	elseif ($fields['password'] != $fields['password2']) :

		setError('wrong_password');
		redirect('../../users.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		if ($fields['password'] == '') unset($fields['password']);
		unset($fields['password2']);
		if ($fields['status'] == '') $fields['status'] = 'inactive';
		$fields['username'] = $fields['email'];

		updateQuery('users', $fields, $_REQUEST['ID']);
		insertLogRecord('users', 'update', $_REQUEST['ID'], $fields['username']);
		setOk('User <strong>' . $fields['username'] . '</strong> updated.');
		redirect('../../users.php');

	endif;

endif;

?>

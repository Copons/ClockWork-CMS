<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array('username' 	=> 'clean',
						 'password' 	=> 'password',
						 'password2'	=> 'password',
						 'role'	 	=> 'clean',
						 'email'	 	=> 'clean',
						 'description' 	=> 'clean');
	$fields = fieldsToArray($arrayFields);




	if ($fields['username']	== '' ||
		$fields['role']	== '' ||
		$fields['email']	== '') :

		setError('required_fields');
		redirect('../../admin.php?action=edit&ID=' . $_REQUEST['ID']);

	elseif ($fields['password'] != $fields['password2']) :

		setError('wrong_password');
		redirect('../../admin.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		if ($fields['password'] == '') unset($fields['password']);
		unset($fields['password2']);
		updateQuery('admin', $fields, $_REQUEST['ID']);
		insertLogRecord('admin', 'update', $_REQUEST['ID'], $fields['username']);
		setOk('Administrator <strong>' . $fields['username'] . '</strong> updated.');
		redirect('../../admin.php');

	endif;

endif;

?>

<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

$arrayFields = array('username'		=> 'clean',
					 'password'		=> 'password',
					 'password2'	=> 'password',
					 'role'			=> 'clean',
					 'email'		=> 'clean',
					 'description'	=> 'clean');
$fields = fieldsToArray($arrayFields);




if ($fields['username']	== '' ||
	$fields['password'] == '' ||
	$fields['password2'] == '' ||
	$fields['role'] == '' ||
	$fields['email'] == '') :

	unset($fields['password']);
	unset($fields['password2']);
	rememberFields('admin', $fields);
	setError('required_fields');
	redirect('../../admin.php?action=insert');

elseif ($fields['password'] != $fields['password2']) :

	unset($fields['password']);
	unset($fields['password2']);
	rememberFields('admin', $fields);
	setError('wrong_password');
	redirect('../../admin.php?action=insert');

else :

	unset($fields['password2']);
	$insertId = insertQuery('admin', $fields);
	insertLogRecord('admin', 'save', $insertId, $fields['username']);
	forgetFields('admin', $fields);
	setOk('Administrator <strong>' . $fields['username'] . '</strong> created.');
	redirect('../../admin.php');

endif;

?>

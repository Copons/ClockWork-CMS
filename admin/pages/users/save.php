<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

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




if ($fields['email']	== '' ||
	$fields['password'] == '' ||
	$fields['password2'] == '') :

	unset($fields['password']);
	unset($fields['password2']);
	rememberFields('users', $fields);
	setError('required_fields');
	redirect('../../users.php?action=insert');

elseif ($fields['password'] != $fields['password2']) :

	unset($fields['password']);
	unset($fields['password2']);
	rememberFields('users', $fields);
	setError('wrong_password');
	redirect('../../users.php?action=insert');

else :

	unset($fields['password2']);
	if ($fields['status'] == '') $fields['status'] = 'inactive';
	$fields['username'] = $fields['email'];
	$fields['date_registered'] = date('Y-m-d H:i:s');

	$insertId = insertQuery('users', $fields);
	insertLogRecord('users', 'save', $insertId, $fields['username']);
	forgetFields('users', $fields);
	setOk('User <strong>' . $fields['username'] . '</strong> created.');
	redirect('../../users.php');

endif;

?>

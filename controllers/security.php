<?php

$cookie = new stdClass();
$user = new stdClass();

foreach ($_COOKIE as $k => $v) :
	if (!strncmp($k, PREFIX, strlen(PREFIX))) :
		$meta_key = str_replace(PREFIX, '', $k);
		if (!strncmp($meta_key, 'error_', strlen('error_'))) :
			$cookie->{$meta_key} = unserialize($v);
			setcookie($k, FALSE, time()-3600*5, '/');
			unset($_COOKIE[$k]);
		elseif (!strncmp($meta_key, 'autocomplete_', strlen('autocomplete_'))) :
			$cookie->{$meta_key} = unserialize($v);
			setcookie($k, FALSE, time()-3600*5, '/');
			unset($_COOKIE[$k]);
		elseif (!strncmp($meta_key, 'sent_', strlen('sent_'))) :
			$cookie->{$meta_key} = unserialize($v);
			setcookie($k, FALSE, time()-3600*5, '/');
			unset($_COOKIE[$k]);
		elseif (!strcmp($meta_key, 'user')) :
			$usr = explode('%', $v);
			//$cookie->id = $user[0];
			//$cookie->username = $user[1];
			try {
				$STH = $DBH->prepare('SELECT id, username, email, first_name, family_name, degree, date_registered
					FROM '.PREFIX.'users WHERE MD5(id) = :id AND MD5(username) = :username LIMIT 1');
				$STH->bindParam(':id', $usr[0]);
				$STH->bindParam(':username', $usr[1]);
				$STH->execute();
				$STH->setFetchMode(PDO::FETCH_OBJ);
				$user = $STH->fetch();
				if (empty($user)) :
					setcookie($k, FALSE, time()-3600*5, '/');
					unset($_COOKIE[$k]);
				endif;
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		else :
			$cookie->{$meta_key} = $v;
		endif;
	endif;
endforeach;

//var_dump($cookie);
//var_dump($user);



// CONVERSION ARRAYS

$error_conv = array(
	'email_empty'		=> '<b>Email</b> is a required field.',
	'email_not_valid'	=> 'Your email is not a valid email address.',
	'password_empty'	=> '<b>Password</b> is a required field.',
	'user_not_exists'	=> 'Wrong username.',
	'user_not_active'	=> 'You are not an active user.',
	'name_empty'		=> '<b>Name</b> is a required field.',
	'subject_empty'		=> '<b>Subject</b> is a required field',
	'message_empty'		=> '<b>Message</b> is a required field'
);




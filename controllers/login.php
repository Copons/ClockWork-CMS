<?php

// Initialize config, DB and helpers

require_once('../admin/include/config.inc.php');
require_once('../helpers/utilities.php');
require_once('../helpers/db.php');
require_once('../helpers/str.php');
require_once('../helpers/config.php');
require_once('../helpers/html.php');
require_once('../helpers/page.php');

//var_dump($_POST); exit();


$email = filter_var($_POST['login_username'], FILTER_SANITIZE_EMAIL);
$password = filter_var($_POST['login_password'], FILTER_SANITIZE_STRING);


$errors = array();

if (empty($email))
	$errors[] = 'email_empty';
else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	$errors[] = 'email_not_valid';

if (empty($password))
	$errors[] = 'password_empty';


if (empty($errors)) :
	try {
		$STH = $DBH->prepare('SELECT id, username, status FROM '.PREFIX.'users WHERE email = :email AND password = :password LIMIT 1');
		$STH->bindParam(':email', $email);
		$STH->bindParam(':password', md5($password));
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$user = $STH->fetch();
		
		if (empty($user))
			$errors[] = 'user_not_exists';
		else if ($user->status != 'active')
			$errors[] = 'user_not_active';
		
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
endif;


if (!empty($errors)) :
	setcookie(PREFIX.'error_login', serialize($errors), 0, '/');
	if (isset($_POST['login_ie']) && $_POST['login_ie'] == 'login_ie') :
		header('Location: ' . $c->ourl() . 'login-ie/');
	else :
		header('Location: ' . $c->ourl());
	endif;
	die();
endif;




setcookie(PREFIX.'user', md5($user->id).'%'.md5($user->username), (time()+(60*60*24*30)), '/');
header('Location: ' . $c->ourl() . 'downloads/');
die();








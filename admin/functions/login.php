<?php

/*
checkLogin	()
failedLogin	()
okLogin		($admin)
logout		()
*/




// CHECK LOGIN
//
// Redirects to the login page if the login check fails
function checkLogin () {
	
	if (!isset($_COOKIE['login']) || (isset($_COOKIE['login']) && $_COOKIE['login'] != 'ok')) :
		setError('wrong_login');
		setcookie('login', 'failed', 0, '/');		
		redirect('index.php');
	endif;
	
}




// FAILED LOGIN
//
// Increments the count of failed logins
function failedLogin () {
	
	if (isset($_COOKIE['loginTry']))
		setcookie("loginTry", $_COOKIE['loginTry']+1, time()+3600, "/");
	else
		setcookie("loginTry", "1", time()+3600, "/");
	setcookie("login", "failed", 0, "/");
	
}




// OK LOGIN
//
// Sets cookies after a correct login
// $admin = the resulting record of the logged in administrator
function okLogin ($admin) {
	
	setcookie('loginTry', '', 0, '/');
	setcookie('login', 'ok', 0, '/');
	setcookie('username', $admin['username'], 0, '/');
	setcookie('userid', $admin['id'], 0, '/');
	setcookie('level', $admin['role'], 0, '/');
	
}




// LOGOUT
//
// Frees all login cookies
function logout () {
	
	setcookie('login', '', 0, '/');
	setcookie('username', '', 0, '/');
	setcookie('userid', '', 0, '/');
	setcookie('level', '', 0, '/');
	session_destroy();
	
}

?>
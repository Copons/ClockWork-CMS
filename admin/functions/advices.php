<?php

/*
clearAdvices	()
setError		($errorMsg)
setOk			($okMsg)
*/




// CLEAR ADVICES
//
// Clears, if needed, "error" and "ok" cookies
function clearAdvices () {

	if (isset($_COOKIE['errorCnt'])) :
		if ($_COOKIE['errorCnt'] == '1') :
			setcookie('error', '', 1, '/');
			setcookie('errorCnt', '0', 1, '/');
		else :
			setcookie('errorCnt', '1', 0, '/');
		endif;
	endif;
	
	if (isset($_COOKIE['okCnt'])) :
		if ($_COOKIE['okCnt'] == '1') :
			setcookie('ok', '', 1, '/');
			setcookie('okCnt', '0', 1, '/');
		else :
			setcookie('okCnt', '1', 0, '/');
		endif;
	endif;

}




// SET ERROR
//
// Sets an error cookie
// $errorMsg = code for error message to display
function setError ($error) {
	
	setcookie('errorCnt', '1', 0, '/');
	setcookie('error', $error, 0, '/');	
	
}




// SET OK
//
// Sets an ok cookie
// $okMsg = success message to display
function setOk ($okMsg) {
	
	setcookie('okCnt', '1', 0, '/');
	setcookie('ok', $okMsg, 0, '/');
	
}

?>
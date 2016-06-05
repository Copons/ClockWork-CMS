<?php

/*
cleanString		($string)
mailString		($string)
outputString	($string)
simpleNewLine	($string)
dateITA			($date, $separator)
datetimeITA		($time, $separator)
dateITAyear		($date, $separator)
monthITA		($monthNumber)
*/




// CLEAN STRING
//
// Cleans a string preventing SQL injection and other security risks
// Needs an open connection to a MySQL database in order to use the right charset
// $string = input string
function cleanString ($string) {
	if ($string == NULL)
		return '';
	if (get_magic_quotes_gpc())
		$value = stripslashes($string);
	$string = htmlentities(trim($string), ENT_QUOTES, 'UTF-8');
	return mysql_real_escape_string($string);
}




// MAIL STRING
//
// Cleans a string for email message body
// $string = input string
function mailString ($string) {
	if ($string == NULL)
		return '';
	$string = strip_tags($string);
	$string = str_replace("\r\n", "\n\t", $string);
	return stripslashes($string);
}




// OUTPUT STRING
//
// Strip every unwanted slash
// $string = input string
function outputString ($string) {
	if ($string == NULL)
		return '';
	return stripslashes($string);
}




// SIMPLE NEW LINE
//
// Replace every "\n" with a "<br />"
// $string = input string
function simpleNewline ($string) {
	if ($string == NULL)
		return '';
	$string = str_replace("\n", '<br />', $string);
	return $string;
}




// DATE ITA
//
// Convert MySQL dates into "DD/MM/YYYY" format
// If $separator isn't set, the format will be "DD MonthName YYYY"
// $date = input date
// $separator = string used to separate days, months and years
//
// HARD CHANGED TO ENGLISH
function dateITA ($date, $separator = '') {
	if ($date == '0000-00-00')
		return;
	$date = explode('-', $date);
	if ($date[0] == '0000') $anno = ''; else $anno = $date[0];
	if ($date[1] == '00') $mese = ''; else $mese = $date[1];
	if ($date[2] == '00') $giorno = ''; else $giorno = $date[2];
	if ($separator != '')
		if ($mese == '')
			return $anno;
		else
			return mese . $separator . giorno . $separator . $anno;
	else
		if ($mese == '')
			return $anno;
		else
			return monthITA($mese) . ' ' . $giorno . ', ' . $anno;
}




// DATETIME ITA
//
// Convert MySQL times into "DD/MM/YYYY HH:MM" format
// If $separator isn't set, the format will be "DD MonthName YYYY, HH:MM"
// $time = input time
// $separator = string used to separate days, months and years
//
// HARD CHANGED TO ENGLISH
function datetimeITA ($time, $separator = '') {
	$day = explode(' ', $time);
	$date = explode('-', $day[0]);
	//$date = substr($time, 0,10);
	$hour = substr($time, -8,5);
	if ($separator != '')
		return $date[1] . $separator . $date[2] . $separator . $date[0] . ' ' . $hour;
	else
		return monthITA($date[1]) . ' ' . $date[2] . ', ' . $date[0] . ', ' . $hour;
}




// DATE ITA YEAR
//
// Convert MySQL dates into "DD/MM/YYYY" format and put the YYYY in bold weight
// If $separator isn't set, the format will be "DD MonthName YYYY"
// $date = input date
// $separator = string used to separate days, months and years
//
// HARD CHANGED TO ENGLISH
function dateITAyear ($date, $separator = '') {
	$date = explode('-', $date);
	if ($separator != '')
		return $date[1] . $separator . $date[2] . $separator . '<strong>' . $date[0] . '</strong>';
	else
		return monthITA($date[1]) . ' ' . $date[2] . ', <strong>' . $date[0] . '</strong>';
}




// MONTH ITA
//
// Replace month number with the italian name
// $monthNumber = number of the input month
//
// HARD CHANGED TO ENGLISH
function monthITA ($monthNumber) {
	if ($monthNumber == NULL || ($monthNumber < 1 && $monthNumber > 12))
		return 'Wrong number';
	$monthArray = array(
		1 => 'January', '1' => 'January', '01' => 'January',
		2 => 'February', '2' => 'February', '02' => 'February',
		3 => 'March', '3' => 'March', '03' => 'March',
		4 => 'April', '4' => 'April', '04' => 'April',
		5 => 'May', '5' => 'May', '05' => 'May',
		6 => 'June', '6' => 'June', '06' => 'June',
		7 => 'July', '7' => 'July', '07' => 'July',
		8 => 'August', '8' => 'August', '08' => 'August',
		9 => 'September', '9' => 'September', '09' => 'September',
		10 => 'October', '10' => 'October',
		11 => 'November', '11' => 'November',
		12 => 'December', '12' => 'December'
	);
	return $monthArray[$monthNumber];
}

?>

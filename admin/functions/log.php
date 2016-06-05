<?php

/*
insertLogRecord		($page, $action, $rowId, $title)
showLogAction		($page, $action, $rowId, $title)
*/



// INSERT LOG RECORD
//
// Saves in the database log table the current action
// $page = page slug
// $action = save, update, delete
// $rowId = element id
// $title = element name
function insertLogRecord ($page, $action, $rowId, $title) {

	$query = 'INSERT INTO '.PREFIX.'logs (log_time, editor, page, action, element, title) VALUES (NOW(), ';
	$query .= "'" . $_COOKIE['userid'] . "', '" . $page . "', '" . $action . "', '" . $rowId . "', '" . $title ."')";
	$result = mysql_query($query) or die(mysql_error());

}




// SHOW LOG ACTION
//
// Shows in a readable way the action saved in the log
// $page = page in which the action took place
// $action = action performed
// $rowId = element id
// $title = element title
function showLogAction ($page, $action, $rowId, $title) {

	global $pageArray;
	$logArray = array('save' 		=> 'Create: ',
					  'update'		=> 'Edit: ',
					  'delete'		=> 'Delete: ',
					  'duplicate'	=> 'Duplicate ');

	$actionPage = 'edit';

	if ($title == '') $title = '<em>[missing name]</em>';

	$log = $logArray[$action];
	if ($action != 'delete')
		$log .= '<a href="' . $page . '.php?action=' . $actionPage . '&amp;ID=' . $rowId . '"><img src="images/link.png" alt="Link" /> [' . $rowId . '] ' . $title . '</a>';
	else
		$log .= $title;
	$log .= ' in ' . $pageArray[$page] . '.';

	return $log;

}

?>

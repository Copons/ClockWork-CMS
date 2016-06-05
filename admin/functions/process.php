<?php

/*
fieldsToArray		($arrayFields)
checkDateDB			($date, $needYear, $needMonth)
rememberFields		($page, $arrayFields)
forgetFields		($page, $arrayFields)
insertQuery			($page, $arrayFields)
editQuery			($page, $arrayFields, $rowId)
deleteQuery			($page, $field, $rowId)
insertFile			($page, $fieldName, $newName, $maxFileSize)
editFile			($page, $fieldName, $rowId, $newName, $maxFileSize)
insertImage			($page, $fieldName, $newName, $maxFileSize)
editImage			($page, $fieldName, $rowId, $newName, $maxFileSize)
deleteFile			($page, $url, $name)
sendAdminNotify		($page, $action, $rowId, $title, $editor)
duplicateRecord		($page, $stringFields)
incrementPosition	($page, $position)
updatePosition		($page, $rowId, $newPosition)
decrementPosition	($page, $rowId)
*/




// FIELDS TO ARRAY
//
// Transforms the requested fields into a cleaned string array
// Keys are field names and values are field contents
// $arrayFields = a simple array with field names as keys and the way to clean a string as values
function fieldsToArray ($arrayFields) {

	$newArrayFields = array();
	$dates = array();
	$datetimes = array();

	foreach ($arrayFields as $name => $cleaner) :
		if ($cleaner == '') :
			$newArrayFields[$name] = $_REQUEST[$name];
		elseif ($cleaner == 'clean') :
			$newArrayFields[$name] = cleanString($_REQUEST[$name]);
		elseif ($cleaner == 'addslashes') :
			$newArrayFields[$name] = addslashes($_REQUEST[$name]);
		elseif ($cleaner == 'password') :
			if ($_REQUEST[$name] != '') :
				$newArrayFields[$name] = md5($_REQUEST[$name]);
			else :
				$field = '';
			endif;
		elseif ($cleaner == 'date') :
			if (substr($name, -3) == 'Day') :
				$dates[substr($name, 0, -3)] = cleanString($_REQUEST[$name]);
			elseif (substr($name, -5) == 'Month') :
				$dates[substr($name, 0, -5)] = cleanString($_REQUEST[$name]) . '-' . $dates[substr($name, 0, -5)];
			elseif (substr($name, -4) == 'Year') :
				$dates[substr($name, 0, -4)] = cleanString($_REQUEST[$name]) . '-' . $dates[substr($name, 0, -4)];
			else :
				$newArrayFields[$name] = '0000-00-00';
			endif;
		elseif ($cleaner == 'datetime') :
			if (substr($name, -3) == 'Day') :
				$datetimes[substr($name, 0, -3)] = cleanString($_REQUEST[$name]);
			elseif (substr($name, -5) == 'Month') :
				$datetimes[substr($name, 0, -5)] = cleanString($_REQUEST[$name]) . '-' . $datetimes[substr($name, 0, -5)];
			elseif (substr($name, -4) == 'Year') :
				$datetimes[substr($name, 0, -4)] = cleanString($_REQUEST[$name]) . '-' . $datetimes[substr($name, 0, -4)];
			elseif (substr($name, -4) == 'Hour') :
				$datetimes[substr($name, 0, -4)] = $datetimes[substr($name, 0, -4)] . ' ' . cleanString($_REQUEST[$name]);
			elseif (substr($name, -6) == 'Minute') :
				$datetimes[substr($name, 0, -6)] = $datetimes[substr($name, 0, -6)] . ':' . cleanString($_REQUEST[$name]);
			else :
				$newArrayFields[$name] = '0000-00-00 00:00';
			endif;
		endif;
	endforeach;

	foreach ($dates as $name => $date)
		$newArrayFields[$name] = checkDateDB($date);

	foreach ($datetimes as $name => $date)
		$newArrayFields[$name] = checkDatetimeDB($date);

	return $newArrayFields;

}




// CHECK DATE DB
//
// Returns false if the inserted date doesn't met the requisites
// Returns a safe date for MySQL insertion
// $name = date input name
// $arrayFields = a simple array with field names as keys and field contents as values
function checkDateDB ($date, $needYear = FALSE, $needMonth = FALSE) {

	$date = explode('-', $date);

	if ($needYear && $date[0] == '')
		return '0000-00-00';
	else if ($needMonth && ($date[0] == '' || $date[1] == ''))
		return '0000-00-00';
	else if ((!$needYear && !$needMonth) && ($date[0] == '' || $date[1] == '' || $date[2] == ''))
		return '0000-00-00';

	if ($date[1] == '') $date[1] = '00';
	if ($date[2] == '') $date[2] = '00';

	if (strlen($date[1]) == 1)
		$date[1] = '0' . $date[1];
	if (strlen($date[2]) == 1)
		$date[2] = '0' . $date[2];

	return $date[0] . '-' . $date[1] . '-'. $date[2];
}




// CHECK DATETIME DB
//
// Returns false if the inserted date doesn't met the requisites
// Returns a safe date for MySQL insertion
// $name = date input name
// $arrayFields = a simple array with field names as keys and field contents as values
function checkDatetimeDB ($date, $needYear = FALSE, $needMonth = FALSE) {

	$datetime = explode(' ', $date);
	$date = explode('-', $datetime[0]);
	$time = explode(':', $datetime[1]);

	if ($needYear && $date[0] == '')
		return '0000-00-00 00:00';
	else if ($needMonth && ($date[0] == '' || $date[1] == ''))
		return '0000-00-00 00:00';
	else if ((!$needYear && !$needMonth) && ($date[0] == '' || $date[1] == '' || $date[2] == ''))
		return '0000-00-00 00:00';

	if ($date[1] == '') $date[1] = '00';
	if ($date[2] == '') $date[2] = '00';

	if ($time[0] == '') $time[0] = '00';
	if ($time[1] == '') $time[1] = '00';

	if (strlen($date[1]) == 1)
		$date[1] = '0' . $date[1];
	if (strlen($date[2]) == 1)
		$date[2] = '0' . $date[2];

	if (strlen($time[0]) == 1)
		$time[0] = '0'.$time[0];
	if (strlen($time[1]) == 1)
		$time[1] = '0'.$time[1];

	return $date[0] . '-' . $date[1] . '-'. $date[2] . ' ' . $time[0] . ':' . $time[1];
}




// REMEMBER FIELDS
//
// Sets a cookie for every inserted field
// $page = the page in which will be used this function
// $arrayFields = a simple array with field names as keys and field contents as values
function rememberFields ($page, $arrayFields) {

	foreach ($arrayFields as $name => $field) :
		setcookie('tmp_' . $page . '_' . $name, $field, 0, '/');
	endforeach;

}




// FORGET FIELDS
//
// Unsets cookies for every inserted field
// $page = the page in which will be used this function
// $arrayFields = a simple array with field names as keys and field contents as values
function forgetFields ($page, $arrayFields) {

	foreach ($arrayFields as $name => $field)
		setcookie('tmp_' . $page . '_' . $name, '', 0, '/');

}




// INSERT QUERY
//
// Inserts data into a MySQL table and returns the inserted record id
// $page = the page in which will be used this function (same as table name)
// $arrayFields = a simple array with field names (same as database field names) as keys and field contents as values
function insertQuery ($page, $arrayFields) {

	$dbFields = '';
	$values = '';
	$meta = array();
	$type = $arrayFields['type'];

	foreach ($arrayFields as $name => $field) :
		if ($page == 'articles' && substr($name, 0, 4) == 'meta') :
			$metaKey = str_replace('meta', $type, $name);
			$meta[$metaKey] = $field;
		else :
			$dbFields .= $name . ', ';
			$values .= "'" . $field . "', ";
		endif;
	endforeach;

	//var_dump($arrayFields);var_dump($meta); die();

	$query = 'INSERT INTO ' . PREFIX.$page . ' (' . $dbFields;
	$query .= 'date_modified, editor) VALUES (' . $values;
	$query .= 'NOW(), ' . $_COOKIE['userid'] . ')';

	$result = mysql_query($query) or die(mysql_error());

	$insert_id =  mysql_insert_id();

	if ($page == 'articles') :
		foreach ($meta as $key => $val) :
			$query = 'INSERT INTO ' . PREFIX . 'meta (article, meta_key, meta_value)
				VALUES ("'.$insert_id.'", "'.$key.'", "'.$val.'")';
			$result = mysql_query($query) or die(mysql_error());
		endforeach;
	endif;

	return $insert_id;

}




// UPDATE QUERY
//
// Updates data into a MySQL table
// $page = the page in which will be used this function (same as table name)
// $arrayFields = a simple array with field names (same as database field names) as keys and field contents as values
// $rowId = element id
function updateQuery ($page, $arrayFields, $rowId) {

	$dbUpdate = '';
	$meta = array();
	$type = $arrayFields['type'];

	foreach ($arrayFields as $name => $field) :
		if ($page == 'articles' && substr($name, 0, 4) == 'meta') :
			$metaKey = str_replace('meta', $type, $name);
			$meta[$metaKey] = $field;
		else :
			$dbUpdate .= $name . " = '" . $field . "', ";
		endif;
	endforeach;

	$query = 'UPDATE ' . PREFIX.$page . ' SET ' . $dbUpdate;
	$query .= 'date_modified = NOW(), editor = ' . $_COOKIE['userid'] . ' ';
	$query .= 'WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());

	if ($page == 'articles' && !empty($meta)) :
		$query = 'DELETE FROM '.PREFIX.'meta WHERE article = "'.$rowId.'"';
		$result = mysql_query($query) or die(mysql_error());
		foreach ($meta as $key => $val) :
			$query = 'INSERT INTO ' . PREFIX . 'meta (article, meta_key, meta_value)
				VALUES ("'.$rowId.'", "'.$key.'", "'.$val.'")';
			$result = mysql_query($query) or die(mysql_error());
		endforeach;
	endif;

}




// DELETE QUERY
//
// Deletes data from a MySQL table and returns the name of the deleted element
// $page = the page in which will be used this function (same as table name)
// $field = the name of the field to be retruned
// $rowId = element id
function deleteQuery ($page, $field, $rowId) {

	$query = 'SELECT ' . $field . ' FROM ' . PREFIX.$page . ' WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	$title = outputString($row[$field]);

	$query = 'DELETE FROM ' . PREFIX.$page . ' WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());

	if ($page == 'articles') :
		$query = 'DELETE FROM '.PREFIX.'meta WHERE article = "'.$rowId.'"';
		$result = mysql_query($query) or die(mysql_error());
	endif;

	return $title;

}




// INSERT FILE
//
// Uploads a file and returns file's filename
// $page = the page in which will be used this function
// $fieldName = form field name
// $newName = file new name
// $maxFileSize = default set up to 500KB
function insertFile ($page, $fieldName, $newName, $maxFileSize = 2000000) {

	if ($_FILES[$fieldName]['error'] != 4) :
		return fileUpload($_FILES[$fieldName], $page, 'insert', $newName, $maxFileSize);
	endif;

}




// EDIT FILE
//
// Uploads (if needed, unlink the previous file before uploading) a file and returns file's filename
// $page = the page in which will be used this function
// $fieldName = form field name
// $rowId = record id
// $newName = file new name
// $maxFileSize = default set up to 500KB
function editFile ($page, $fieldName, $rowId, $newName, $maxFileSize = 2000000) {

	$queryImage = 'SELECT ' . $fieldName . ' FROM ' . PREFIX.$page . ' WHERE id = ' . $_REQUEST['ID'];
	$resultImage = mysql_query($queryImage) or die(mysql_error());
	$rowImage = mysql_fetch_assoc($resultImage);

	if ($_FILES[$fieldName]['error'] != 4) :

		if (is_file('../../../uploads/' . $page . '/' . $rowImage[$fieldName])) :
			unlink('../../../uploads/' . $page . '/' . $rowImage[$fieldName]);
		endif;

		return fileUpload($_FILES[$fieldName], $page, 'edit', $newName, $maxFileSize);

	else :

		return $rowImage[$fieldName];

	endif;

}




// INSERT IMAGE
//
// Uploads an image and returns image's filename
// $page = the page in which will be used this function
// $fieldName = form field name
// $newName = image new name
// $maxFileSize = default set up to 500KB
function insertImage ($page, $fieldName, $newName, $maxFileSize = 2000000) {

	if ($_FILES[$fieldName]['error'] != 4) :
		return imageUpload($_FILES[$fieldName], $page, 'insert', $newName, $maxFileSize);
	endif;

}




// EDIT IMAGE
//
// Uploads (if needed, unlink the previous image before uploading) an image and returns image's filename
// $page = the page in which will be used this function
// $fieldName = form field name
// $rowId = record id
// $newName = image new name
// $maxFileSize = default set up to 500KB
function editImage ($page, $fieldName, $rowId, $newName, $sizes = '', $pagetype = '', $maxFileSize = 2000000) {

	$queryImage = 'SELECT ' . $fieldName . ' FROM ' . PREFIX.$pagetype . ' WHERE id = ' . $_REQUEST['ID'];
	$resultImage = mysql_query($queryImage) or die(mysql_error());
	$rowImage = mysql_fetch_assoc($resultImage);

	if ($_FILES[$fieldName]['error'] != 4) :

		if (is_file('../../../uploads/' . $page . '/' . $rowImage[$fieldName])) :
			unlink('../../../uploads/' . $page . '/' . $rowImage[$fieldName]);
		endif;

		foreach ($sizes as $w => $h) :
			if ($w != '' && $h != '' && is_file('../../../uploads/' . $page . '/' . $w . 'x' . $h . '-' . $rowImage[$fieldName])) :
				unlink('../../../uploads/' . $page . '/' . $w . 'x' . $h . '-' . $rowImage[$fieldName]);
			endif;
		endforeach;

		return imageUpload($_FILES[$fieldName], $page, 'edit', $newName, $maxFileSize);

	else :

		return $rowImage[$fieldName];

	endif;

}




// DELETE FILE
//
// Deletes the target file
// $page = the page in which will be used this function
// $url = file url
// $name = if it's set, it's the name of the image record field of the image that will be deleted
function deleteFile ($page, $url, $pagetype = '', $name = '') {

	if ($name == '') :
		if (is_file('../../../uploads/' . $page . '/' . $url)) :
			unlink('../../../uploads/' . $page . '/' . $url);
		endif;
	else :
		$queryImage = 'SELECT ' . $name . ' FROM ' . PREFIX.$pagetype . ' WHERE id = ' . $_REQUEST['ID'];
		$resultImage = mysql_query($queryImage) or die(mysql_error());
		$rowImage = mysql_fetch_assoc($resultImage);
		if (is_file('../../../uploads/' . $page . '/' . $rowImage[$name])) :
			unlink('../../../uploads/' . $page . '/' . $rowImage[$name]);
		endif;
		return $rowImage[$name];
	endif;

}

function deleteMetaFile ($page, $meta_key) {

	$queryImage = 'SELECT meta_value FROM ' . PREFIX . 'meta WHERE meta_key = "' . cleanString($meta_key) . '" AND article = ' . $_REQUEST['ID'];
	$resultImage = mysql_query($queryImage) or die(mysql_error());
	$rowImage = mysql_fetch_assoc($resultImage);
	if (is_file('../../../uploads/' . $page . '/' . $rowImage['meta_value'])) :
		unlink('../../../uploads/' . $page . '/' . $rowImage['meta_value']);
	endif;
	return $rowImage['meta_value'];

}




// SEND ADMIN NOTIFY
//
// Sends an email to every admin notifying that an editor has changed something in the CMS
// $page = page in which the action took place
// $action = action performed
// $rowId = element id
// $title = element title
// $editor = editor id
function sendAdminNotify ($page, $action, $rowId, $title, $editor) {

	global $cms;
	global $config;
	global $pageArray;
	$textArray = array('save' 		=> 'Create: ',
					  'update'		=> 'Update: ',
					  'delete'		=> 'Delete: ',
					  'duplicate'	=> 'Duplicate: ');

	if ($page == 'config') $actionPage = 'edit';
	else $actionPage = 'single';

	if ($title == '') $title = '<em>[missing name]</em>';

	$queryEditor = 'SELECT username FROM '.PREFIX.'admin WHERE id = ' . $editor . ' LIMIT 1';
	$resultEditor = mysql_query($queryEditor) or die(mysql_error());
	$rowEditor = mysql_fetch_assoc($resultEditor);

	$addresses = array();
	$queryAdmin = "SELECT email FROM ".PREFIX."admin WHERE role = 'admin'";
	$resultAdmin = mysql_query($queryAdmin) or die(mysql_error());
	while ($rowAdmin = mysql_fetch_assoc($resultAdmin))
		$addresses[] = $rowAdmin['email'];

	$text = $textArray[$action];
	if ($action != 'delete')
		$text .= '<a href="' . $config['site_url'] . 'admin/' . $page . '.php?action=' . $actionPage . '&amp;ID=' . $rowId . '">[' . $rowId . '] ' . $title . '</a>';
	else
		$text .= $title;
	$text .= ' in ' . $pageArray[$page] . '<br>';
	$text .= 'da parte di <a href="' . $config['site_url'] . 'admin/admin.php?action=single&amp;ID=' . $editor . '">' . $rowEditor['nickname'] . '</a>.';

	$to = implode(', ', $addresses);
	$from = $config['site_email'];
	$subject = $config['site_name'] . ' - Automatic message';

	$message = '
<html>
	<body>
	<b>' . $config['site_name'] . ' - Automatic message</b>
	<br><br>
	' . $text . '
	<br><br><br><br>
	<i><strong>' . $cms['name'] . ' ' . $cms['version'] . '</strong> &copy; ' . $cms['year'] . ' ' . $cms['copyright'] . '</i>
	</body>
</html>
';
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "From: $from\r\n";
	$headers .= "Content-type: text/html\r\n";

	mail($to, $subject, $message, $headers);

}




// DUPLICATE RECORD
//
//
function duplicateRecord ($page, $arrayFields, $rowId) {

	$fields = implode(', ', $arrayFields);

	$query = 'INSERT INTO ' . PREFIX.$page . ' (' . $fields . ')
			  SELECT ' . $fields . ' FROM ' . PREFIX.$page . ' WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());

	return mysql_insert_id();

}




// COPY FILE
//
//
function copyFile ($page, $oldName, $newName) {

	copy('../../../uploads/' . $page . '/' . $oldName, '../../../uploads/' . $page . '/' . $newName);

}



// INCREMENT POSITION
//
//
function incrementPosition ($table, $type, $position) {

	$query = 'UPDATE ' . PREFIX.$table . ' SET position = position + 1 WHERE type = "' . $type . '" AND position >= "' . $position . '" ORDER BY position ASC';
	$result = mysql_query($query) or die(mysql_error());

}



// UPDATE POSITION
//
//
function updatePosition ($table, $type, $rowId, $newPosition) {

	$query = 'SELECT position FROM ' . PREFIX.$table . ' WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	$oldPosition = $row['position'];

	if($newPosition > $oldPosition) $newPosition --;

	$query = 'UPDATE ' . PREFIX.$table . ' SET position = position + 1 WHERE type = "' . $type . '" AND position >= "' . $newPosition . '" AND position < "' . $oldPosition . '"';
	$result = mysql_query($query) or die(mysql_error());

	$query = 'UPDATE ' . PREFIX.$table . ' SET position = position - 1 WHERE type = "' . $type . '" AND position <= "' . $newPosition . '" AND position >= "' . $oldPosition . '"';
	$result = mysql_query($query) or die(mysql_error());

	return $newPosition;

}



// DECREMENT POSITION
//
//
function decrementPosition ($table, $type, $rowId) {

	$query = 'SELECT position FROM ' . PREFIX.$table . ' WHERE id = ' . $rowId . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);

	$query = 'UPDATE ' . PREFIX.$table . ' SET position = position - 1 WHERE type = "' . $type . '" AND position > "' . $row['position'] . '" ORDER BY position ASC';
	$result = mysql_query($query) or die(mysql_error());

}

<?php

require('../../include/process.inc.php');
require('array.php');


$position = -1;
$curr_where = '';
if (isset($_REQUEST['item']) && is_numeric($_REQUEST['item'])) :
	$qcurr = 'SELECT position FROM '.PREFIX.'articles WHERE id = "'.cleanString($_REQUEST['item']).'" LIMIT 1';
	$rcurr = mysql_query($qcurr) or die(mysql_error());
	if (mysql_num_rows($rcurr) == 1) :
		$curr = mysql_fetch_assoc($rcurr);
		if ($curr['position'] != '' && $curr['position'] > 0) :
			$curr_where = ' id != "'.cleanString($_REQUEST['item']).'" AND ';
			$position = $curr['position'];
		endif;
	endif;
endif;



$arrayPosition = array();
$qPos = 'SELECT
	position, title
FROM
	'.PREFIX.'articles
WHERE
	'.$curr_where.'
	type = "page" AND
	parent = "'.cleanString($_REQUEST['parent']).'"
ORDER BY position ASC';
$rPos = mysql_query($qPos) or die(mysql_error());
if (mysql_num_rows($rPos) == 0) :
	$qtot = 'SELECT id FROM '.PREFIX.'articles WHERE type = "page"';
	$rtot = mysql_query($qtot) or die(mysql_error());
	$tot = mysql_num_rows($rtot);
	$arrayPosition[$tot+1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;


$i = 1;
$selected = false;
foreach ($arrayPosition as $k => $v) :

	echo '<option value="'.$k.'"';
	if ($position > -1 && $position < $k && !$selected) :
		echo ' selected="selected"';
		$selected = true;
	endif;
	if ($i == count($arrayPosition) && !$selected) :
		echo ' selected="selected"';
		$selected = true;
	endif;
	echo '>'.$v.'</option>';

	$i++;

endforeach;

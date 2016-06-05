<?php

$arrayStatus = array(
	'draft'		=> 'Draft',
	'published'	=> 'Published'
);

$arrayPosition = array();
$qPos = 'SELECT position, title FROM '.PREFIX.'articles WHERE type = "featured" ORDER BY position ASC';
$rPos = mysql_query($qPos) or die(mysql_query());
if (mysql_num_rows($rPos) == 0) :
	$arrayPosition[1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;

?>

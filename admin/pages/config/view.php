<?php

$headerArray = array('id'		=> 'ID',
					 'item'		=> 'Option',
					 'value'	=> 'Value',
					 'date_modified'	=> 'Last Edit');

$orderArray = array();

$rowsPerPage = 15;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'config';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT * FROM '.PREFIX.'config ORDER BY id ASC ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no options in the database.');
else :
	require('pages/config/array.php');
	viewPaging('config', $count, $rowsPerPage);
	viewHeader('config', $headerArray, $orderArray);
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		($arrayOptions[$row['item']], '', '', 'config', $row['id']);
		viewString		($row['value']);
		viewLastEdit	($row['date_modified'], $row['editor']);
		viewServices	('config', 'Option', $row['id'], $rowBg);

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('config', $count, $rowsPerPage, 'footer');
endif;

?>

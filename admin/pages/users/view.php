<?php

$headerArray = array(
	'id'				=> 'ID',
	'email'				=> 'Email',
	'status'			=> 'Status',
	'date_registered'	=> 'Registered',
	'date_modified'		=> 'Last Edit'
);

$orderArray = array(
	'date_registered'	=> 'DESC',
	'email' 			=> 'ASC',
	'id' 				=> 'ASC',
	'status'			=> 'ASC',
	'date_modified'		=> 'DESC'
);

$orderString = orderByString(reorderArray($orderArray));

$rowsPerPage = 15;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'users';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT * FROM '.PREFIX.'users ' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no users in the database.');
else :
	require('pages/users/array.php');
	viewPaging('users', $count, $rowsPerPage);
	viewHeader('users', $headerArray, $orderArray);
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		($row['email'], '', '', 'users', $row['id']);
		viewString		($arrayStatus[$row['status']]);
		viewString		(datetimeITA($row['date_registered']));
		viewLastEdit	($row['date_modified'], $row['editor']);

		viewServices	('users', 'User', $row['id'], $rowBg);

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('users', $count, $rowsPerPage, 'footer');
endif;

?>

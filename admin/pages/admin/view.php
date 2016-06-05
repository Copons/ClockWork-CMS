<?php

$headerArray = array('id'			=> 'ID',
					 'username'		=> 'Username',
					 'role'			=> 'Role',
					 'email'		=> 'Email',
					 'description'	=> 'Description',
					 'date_modified'		=> 'Last Edit');

$orderArray = array('username' 	=> 'ASC',
					'role' 	=> 'ASC',
					'id' 		=> 'ASC',
					'date_modified' 	=> 'DESC');

$orderString = orderByString(reorderArray($orderArray));

$rowsPerPage = 15;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'admin';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT * FROM '.PREFIX.'admin ' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no administrators in the database.');
else :
	require('pages/admin/array.php');
	viewPaging('admin', $count, $rowsPerPage);
	viewHeader('admin', $headerArray, $orderArray);
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		($row['username'], '', '', 'admin', $row['id']);
		viewString		($arrayLivelli[$row['role']]);
		viewString		($row['email'], '', '','','', 'mailto:' . $row['email']);
		viewString		($row['description']);
		viewLastEdit	($row['date_modified'], $row['editor']);
		viewServices	('admin', 'Administrator', $row['id'], $rowBg);

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('admin', $count, $rowsPerPage, 'footer');
endif;

?>

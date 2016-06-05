<?php

$headerArray = array('id'			=> 'ID',
					 'log_time'		=> 'Date',
					 'author_name'	=> 'User',
					 'azione'		=> 'Action');

$orderArray = array('log_time' 		=> 'DESC',
					'author_name' 	=> 'ASC',
					'id'			=> 'ASC');

$orderString = orderByString(reorderArray($orderArray));

$rowsPerPage = 30;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'logs AS l, '.PREFIX.'admin AS a WHERE a.id = l.editor';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT
	l.id AS id,
	l.log_time AS log_time,
	l.page AS page,
	l.action AS action,
	l.element AS element,
	l.title AS title,
	a.username AS author_name,
	a.id AS author_id
FROM
	'.PREFIX.'logs AS l, '.PREFIX.'admin AS a
WHERE
	a.id = l.editor
' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no logs in the database.');
else :
	viewPaging('logs', $count, $rowsPerPage);
	viewHeader('logs', $headerArray, $orderArray, 'admin', TRUE);
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		(datetimeITA($row['log_time']));
		viewString		($row['author_name'], '', 'b', '','','admin.php?action=edit&amp;ID=' . $row['author_id']);
		viewString		(showLogAction($row['page'], $row['action'], $row['element'], $row['title']));
		viewServices	('', '', '', $rowBg, 'admin', TRUE);

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('logs', $count, $rowsPerPage, 'footer');
endif;

?>

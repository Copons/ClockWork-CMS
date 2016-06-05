<?php

$headerArray = array(
	'id'			=> 'ID',
	'position'		=> 'Pos.',
	'title'			=> 'Title',
	'special'		=> 'Special',
	'parent'		=> 'Parent',
	'status'		=> 'Status',
	'date_modified'	=> 'Last Edit'
);

$orderArray = array(
	'position'		=> 'ASC',
	'title'			=> 'ASC',
	'id' 			=> 'ASC',
	'status'		=> 'DESC',
	'date_modified' => 'DESC'
);

$orderString = orderByString(reorderArray($orderArray));

$rowsPerPage = 15;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'articles WHERE type = "page"';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT
	a.id AS id,
	a.position AS position,
	a.title AS title,
	a.parent AS parent,
	a.status AS status,
	a.editor AS editor,
	a.date_modified AS date_modified,
	m.meta_value AS special
FROM
	'.PREFIX.'articles AS a
LEFT JOIN
	'.PREFIX.'meta AS m
ON
	a.id = m.article AND
	m.meta_key = "page_special"
WHERE
	a.type = "page"
' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no pages in the database.');
else :
	require('pages/pages/array.php');
	viewPaging('pages', $count, $rowsPerPage);
	viewHeader('pages', $headerArray, $orderArray, 'admin,supervisor');
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		($row['position'], 'small');
		viewString		($row['title'], '', '', 'pages', $row['id']);
		viewString		($arraySpecial[$row['special']]);
		viewString		($arrayPages[$row['parent']]);
		viewString		($arrayStatus[$row['status']]);
		viewLastEdit	($row['date_modified'], $row['editor']);
		viewServices	('pages', 'Page', $row['id'], $rowBg, 'admin,supervisor');

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('pages', $count, $rowsPerPage, 'footer');
endif;

?>

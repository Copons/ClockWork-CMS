<?php

$headerArray = array(
	'id'			=> 'ID',
	'position'		=> 'Pos.',
	'title'			=> 'Titolo',
	'featured_image'=> 'Immagine',
	'page'			=> 'Pagina',
	'status'		=> 'Status',
	'date_modified'	=> 'Ultima Modifica'
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

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'articles WHERE type = "featured"';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT
	a.id AS id,
	a.title AS title,
	a.featured_image AS featured_image,
	a.position AS position,
	a.status AS status,
	a.editor AS editor,
	a.date_modified AS date_modified,
	m.meta_value AS page
FROM
	'.PREFIX.'articles AS a
LEFT JOIN
	'.PREFIX.'meta AS m
ON
	a.id = m.article AND
	m.meta_key = "featured_page"
WHERE
	a.type = "featured"
' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no featured elements in the database.');
else :
	require('pages/pages/array.php');
	require('pages/featured/array.php');
	viewPaging('featured', $count, $rowsPerPage);
	viewHeader('featured', $headerArray, $orderArray, 'admin,supervisor');
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		($row['position'], 'small');
		viewString		($row['title'], '', '', 'featured', $row['id']);
		viewImage		('featured', 'small', $row['featured_image'], 0, 50, '150x150-');
		viewString		($arrayPages[$row['page']]);
		viewString		($arrayStatus[$row['status']]);
		viewLastEdit	($row['date_modified'], $row['editor']);
		viewServices	('featured', 'featured', $row['id'], $rowBg, 'admin,supervisor');

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('featured', $count, $rowsPerPage, 'footer');
endif;

?>

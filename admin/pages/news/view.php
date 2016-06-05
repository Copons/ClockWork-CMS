<?php

$headerArray = array(
	'id'			=> 'ID',
	'date_published'=> 'Date',
	'title'			=> 'Title',
	'featured_image'=> 'Image',
	'status'		=> 'Status',
	'date_modified'	=> 'Last Edit'
);

$orderArray = array(
	'date_published'=> 'DESC',
	'title'			=> 'ASC',
	'id' 			=> 'ASC',
	'status'		=> 'DESC',
	'date_modified' => 'DESC'
);

$orderString = orderByString(reorderArray($orderArray));

$rowsPerPage = 15;

$query = 'SELECT COUNT(*) AS tot FROM '.PREFIX.'articles WHERE type = "news"';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$count = $row['tot'];




$query = 'SELECT * FROM '.PREFIX.'articles WHERE type = "news" ' . $orderString . ' ' . viewPagingString($rowsPerPage);
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) :
	default_message('There are no news in the database.');
else :
	require('pages/news/array.php');
	viewPaging('news', $count, $rowsPerPage);
	viewHeader('news', $headerArray, $orderArray, 'admin,supervisor');
	$rowBg = 'dark';
	while ($row = mysql_fetch_assoc($result)) :

		echo '<tr class="' . $rowBg . '">';

		viewString		($row['id'], 'small');
		viewString		(dateITA($row['date_published']), 'small');
		viewString		($row['title'], '', '', 'news', $row['id']);
		viewImage		('news', 'small', $row['featured_image'], 0, 50, '300x150-');
		viewString		($arrayStatus[$row['status']]);
		viewLastEdit	($row['date_modified'], $row['editor']);
		viewServices	('news', 'News', $row['id'], $rowBg, 'admin,supervisor');

		echo '</tr>';
		$rowBg = altRowBg($rowBg);

	endwhile;
	viewFooter();
	viewPaging('news', $count, $rowsPerPage, 'footer');
endif;

?>

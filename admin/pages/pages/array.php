<?php

$arrayStatus = array(
	'draft'		=> 'Draft',
	'published'	=> 'Published'
);

$arraySpecial = array(
	'homepage'	=> 'Home',
	'contacts'	=> 'Contacts'
);

$arrayPages = $arrayPagesSelect = array(0 => '[Homepage]');

function arrayPages ($parent, $depth, &$arrayPages, &$arrayPagesSelect) {

	$qarr = 'SELECT
			m.id AS id,
			m.parent AS parent,
			m.position AS position,
			m.title AS title,
			c.id AS child
		FROM
			'.PREFIX.'articles AS m
		LEFT JOIN
			'.PREFIX.'articles AS c
		ON
			m.id = c.parent
		WHERE
			m.parent = "'.$parent.'" AND
			m.type = "page"
		GROUP BY
			m.id
		ORDER BY m.position ASC
	';
	$rarr = mysql_query($qarr) or die(mysql_error());
	while ($arr = mysql_fetch_assoc($rarr)) :

		$sep = '';
		for ($i=0; $i<$depth; $i++)
			$sep .= '&nbsp; &nbsp; ';
		$arrayPagesSelect[$arr['id']] = outputString($sep . $arr['title']);

		if (isset($arrayPages[$arr['parent']])) :
			$par = $arrayPages[$arr['parent']] . ' &gt; ';
		endif;
		$arrayPages[$arr['id']] = outputString($par.' '.$arr['title']);

		arrayPages($arr['id'], $depth + 1, $arrayPages, $arrayPagesSelect);
	endwhile;

	$depth = 0;

}

arrayPages(0,0,$arrayPages,$arrayPagesSelect);





$arrayPosition = array();
$qPos = 'SELECT position, title FROM '.PREFIX.'articles WHERE type = "page" ORDER BY position ASC';
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

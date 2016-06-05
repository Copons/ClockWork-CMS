<?php

function breadcrumbs ($P) {

	global $DBH, $c, $types;


	HTML::ctag('a', array(
		'href'	=> $c->ourl()
	), 'HOME');

	if ($P->type == 'home') :
		return;
	endif;

	if ($P->type != 'page') :
		echo ' / ';
		HTML::ctag('a', array(
			'href'	=> STR::url($c->ourl(), $P->type)
		), $types[$P->type]);
		if (!empty($P->id)) :
			echo ' / ';
			HTML::ctag('a', array(
				'href'	=> STR::url($c->ourl(), $P->type, $P->id, $P->title)
			), STR::o($P->title));
		endif;
		return;
	endif;


	// ELSE type is page

	$breadcrumbs = '';
	breadcrumbsRecursive($P->id, 'page', $breadcrumbs);
	echo $breadcrumbs;

}




function breadcrumbsRecursive ($id, $type, &$breadcrumbs) {

	global $DBH, $c;

	try {
		$STH = $DBH->prepare('SELECT
				m.id AS id,
				m.parent AS parent,
				m.position AS position,
				m.content AS content,
				m.title AS title
			FROM
				'.PREFIX.'articles AS m
			WHERE
				m.id = :id AND
				m.type = :type AND
				m.status = "published"
			ORDER BY m.position ASC
		');
		$STH->bindParam(':id', $id);
		$STH->bindParam(':type', $type);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while ($m = $STH->fetch()) :
			if ($m->content != '')
				$href = STR::url($c->ourl(), 'page', $m->id, $m->title);
			else
				$href = '#';
			$breadcrumbs =  HTML::ctag('a', array(
				'href'	=> $href
			), STR::o($m->title), false) . $breadcrumbs;
			$breadcrumbs = ' / ' . $breadcrumbs;
			breadcrumbsRecursive($m->parent, $type, $breadcrumbs);
		endwhile;
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}

}


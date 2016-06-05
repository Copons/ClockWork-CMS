<?php

$types = array(
	'page'		=> 'Pages',
	'news'		=> 'News',
	'contacts'	=> 'Contacts'
);




$P = new Page();

$P->type = 'home';
$P->action = 'view';

if (isset($_REQUEST['type']) && $_REQUEST['type'] != '' && array_key_exists($_REQUEST['type'], $types))
	$P->type = $_REQUEST['type'];

if (isset($_REQUEST['article']) && $_REQUEST['article'] != '')
	$P->id = $_REQUEST['article'];

if (isset($_REQUEST['pagenum']) && is_numeric($_REQUEST['pagenum']))
	$P->pagenum = $_REQUEST['pagenum'];
else
	$P->pagenum = 1;




if ($P->type != 'home' && $P->type != 'contacts' && empty($P->id)) :

	$P->pagetitle = $types[$P->type] . ' - ';




elseif ($P->type == 'contacts') :

	try {
		$STH = $DBH->query('SELECT
			a.id AS id,
			a.title AS title,
			a.subtitle AS subtitle,
			a.excerpt AS excerpt,
			a.content AS content,
			a.type AS type,
			a.parent AS parent,
			a.position AS position,
			a.featured_image AS featured_image,
			a.seo_description AS seo_description,
			a.date_published AS date_published,
			a.date_modified AS date_modified,
			a.editor AS editor,
			a.status AS status
		FROM
			'.PREFIX.'articles AS a,
			'.PREFIX.'meta AS m
		WHERE
			a.status = "published" AND
			a.id = m.article AND
			m.meta_key = "page_special" AND
			m.meta_value = "contacts"
		ORDER BY
			a.position ASC
		LIMIT 1');
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_CLASS, 'Page');
		$P = $STH->fetch();
		if ($P->id == '') :
			header('Location: ' . $c->ourl());
			die();
		endif;
		$P->pagetitle = STR::o($P->title . ' - ');
		$P->action .= 'single';
		$P->meta->special = 'contacts';
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}




elseif (!empty($P->type) && !empty($P->id)) :

	try {
		$STH = $DBH->prepare('SELECT * FROM '.PREFIX.'articles WHERE type = :type AND id = :article AND status = "published" LIMIT 1');
		$STH->bindParam(':type', $P->type);
		$STH->bindParam(':article', $P->id);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_CLASS, 'Page');
		$P = $STH->fetch();
		if ($P->id == '') :
			header('Location: ' . $c->ourl());
			die();
		endif;
		$P->pagetitle = STR::o($P->title . ' - ');
		$P->action .= 'single';

		$STH = $DBH->prepare('SELECT * FROM '.PREFIX.'meta WHERE article = :id ORDER BY id ASC');
		$STH->bindParam(':id', $P->id);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while ($meta = $STH->fetch()) :
			$meta_key = str_replace($P->type.'_', '', $meta->meta_key);
			$P->meta->{$meta_key} = $meta->meta_value;
		endwhile;
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}

endif;

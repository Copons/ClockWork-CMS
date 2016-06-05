<?php
try {
	$STH = $DBH->prepare('SELECT
		a.id AS id,
		a.title AS title,
		a.subtitle AS subtitle,
		a.content AS content
	FROM
		'.PREFIX.'articles AS a,
		'.PREFIX.'meta AS m
	WHERE
		a.type = "page" AND
		a.status = "published" AND
		a.id = m.article AND
		m.meta_key = "page_special" AND
		m.meta_value = "homepage"
	ORDER BY
		a.position ASC
	LIMIT 1');

	$STH->execute();
	$STH->setFetchMode(PDO::FETCH_CLASS, 'Page');
	$H = $STH->fetch();
	$H->pagetitle = STR::o($H->title . ' - ');
	$H->action .= 'single';
}
catch (PDOException $e) {
	echo $e->getMessage();
}
?>

<article class="jumbotron m-b-0">
	<h1><?php STR::e($H->title); ?></h1>
	<h2><?php STR::e($H->subtitle); ?></h2>
	<?php STR::e($H->content); ?>

	<a href="./admin" class="btn btn-secondary btn-lg">Login to the Dashboard</a>

	<?php require('views/photogallery/view.php'); ?>
</article>

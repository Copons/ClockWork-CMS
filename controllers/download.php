<?php

// Initialize config, DB and helpers

require_once('../admin/include/config.inc.php');
require_once('../helpers/utilities.php');
require_once('../helpers/db.php');
require_once('../helpers/str.php');
require_once('../helpers/config.php');
require_once('../helpers/html.php');
require_once('../helpers/page.php');
require_once('security.php');

if ($user->id == '') :
	header('Location: ' . $c->ourl());
	die();
endif;


if (isset($_REQUEST['article']) && is_numeric($_REQUEST['article'])) :


	try {
		$STH = $DBH->prepare('SELECT * FROM '.PREFIX.'articles WHERE type = "downloads" AND id = :article AND status = "published" LIMIT 1');
		$STH->bindParam(':article', $_REQUEST['article']);
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

		$STH = $DBH->prepare('INSERT INTO '.PREFIX.'downloads (article, user, date_downloaded) VALUES (:article, :user, NOW())');
		$STH->bindParam(':article', $P->id);
		$STH->bindParam(':user', $user->id);
		$STH->execute();

		$STH = $DBH->prepare('UPDATE '.PREFIX.'meta SET meta_value  = CAST(meta_value AS UNSIGNED) + 1 WHERE article = :article AND meta_key = "downloads_download_count"');
		$STH->bindParam(':article', $P->id);
		$STH->execute();

		header('Location: ' . $c->ourl() . 'uploads/downloads/' . $P->meta->file);
		die();
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	echo 'ciao';


endif;
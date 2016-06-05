<section class="col-xs-12">
    <h1>News</h1>
<?php
try {
	$elemPerPage = 3;
	$STH = $DBH->prepare('SELECT id, title, excerpt, date_published, featured_image
        FROM '.PREFIX.'articles
		WHERE type = "news" AND status = "published" ORDER BY date_published DESC LIMIT :pagenum, :perpage');
	$STH->bindValue(':pagenum', intval(($P->pagenum-1)*$elemPerPage), PDO::PARAM_INT);
	$STH->bindValue(':perpage', intval($elemPerPage), PDO::PARAM_INT);
	$STH->execute();
	$STH->setFetchMode(PDO::FETCH_OBJ);
	while ($n = $STH->fetch()) : ?>

    <div class="row p-y-1">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <a href="<?php echo STR::url($c->ourl(), 'news', $n->id, $n->title) ?>">
                <img class="img-fluid img-block" src="<?php
                    echo $c->ourl().'uploads/news/300x150-'.STR::o($n->featured_image);
                ?>">
            </a>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <p class="text-muted m-b-0"><?php echo STR::dateEng($n->date_published, '.'); ?></p>
            <p class="lead m-b-0">
                <a href="<?php echo STR::url($c->ourl(), 'news', $n->id, $n->title) ?>">
                    <?php STR::e($n->title); ?>
                </a>
            </p>
            <p><?php STR::e($n->excerpt); ?></p>
        </div>
    </div>

    <?php endwhile;
    pagination($P, 'date_published DESC', $elemPerPage);
}
catch (PDOException $e) {
	echo $e->getMessage();
}
?>
</section>

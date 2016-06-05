<article class="col-xs-12">

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <img class="img-fluid img-block" src="<?php
                echo $c->ourl().'uploads/news/300x150-'.STR::o($P->featured_image);
            ?>">
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <h1><?php STR::e($P->title); ?></h1>
        	<p class="lead"><?php echo STR::dateEng($P->date_published, '.'); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php STR::e($P->content); ?>
        </div>
    </div>

	<?php require('views/photogallery/view.php'); ?>
</article>

<div class="col-xs-12 text-xs-center p-y-2">
    <a href="<?php echo STR::url($c->ourl(), 'news') ?>" class="btn btn-primary btn-lg">
        Back to the news
    </a>
</div>

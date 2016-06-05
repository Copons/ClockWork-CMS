<article class="col-xs-12">
	<h1><?php STR::e($P->title); ?></h1>

	<p class="lead"><?php STR::e($P->subtitle); ?></p>

	<?php STR::e($P->content); ?>

	<?php
	try {
		if (file_exists('views/'.$P->meta->special.'/view.php')) :
			require('views/'.$P->meta->special.'/view.php');
		endif;
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}

	require('views/photogallery/view.php');

	?>
</article>

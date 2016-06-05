<nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
	<a class="navbar-brand hidden-sm-down" href="<?php $c->url(); ?>">
		<?php $c->e('name'); ?>
	</a>
	<ul class="nav navbar-nav">
		<?php pagesMenuRecursive(0,0); ?>
	</ul>
</nav>

<div class="container p-t-3">

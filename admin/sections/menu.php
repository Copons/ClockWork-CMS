<?php if ($page != 'login') : ?>

<nav id="main-menu">
	<ul class="clear">
		<?php
			mainMenu('news', '', $page);
			mainMenu('pages', '', $page);
			mainMenu('featured', '', $page);
			mainMenu('users', '', $page);
			mainMenu('admin', 'admin', $page);
			mainMenu('config', 'admin', $page);
			mainMenu('logs', 'admin', $page);
		?>
	</ul>
</nav>

<?php
	menu($page);
endif;

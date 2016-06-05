<?php

function pagination ($P, $order = 'date_published DESC', $elemPerPage = 5) {

	global $DBH, $c;

	if (!$P->pagenum) :
		$currPage = 1;
	else :
		$currPage = $P->pagenum;
	endif;

	try {
		$STH = $DBH->query('SELECT COUNT(*) AS tot FROM '.PREFIX.'articles
			WHERE type = "'.$P->type.'" AND status = "published"');
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$count = $STH->fetch();
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}

	$maxPage = ceil($count->tot/$elemPerPage);

	if ($currPage > $maxPage)
		$currPage = $maxPage;

	if ($maxPage > 1 && $maxPage >= $currPage) :
?>

<nav>
	<ul class="pagination">
		<?php if ($currPage > 1) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo STR::url($c->ourl(), $P->type, 'page', ($currPage - 1)); ?>">
					&laquo;
				</a>
			</li>
		<?php endif; ?>
		<?php for ($i = 1; $i <= $maxPage; $i++) :
			$active = $i == $currPage ? ' active' : ''; ?>
			<li class="page-item<?php echo $active; ?>">
				<a class="page-link" href="<?php echo STR::url($c->ourl(), $P->type, 'page', $i); ?>">
					<?php echo $i; ?>
				</a>
			</li>
		<?php endfor; ?>
		<?php if ($currPage < $maxPage) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo STR::url($c->ourl(), $P->type, 'page', ($currPage + 1)); ?>">
					&raquo;
				</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>

<?php
	endif;
}

<?php

function pagesMenuRecursive ($parent, $depth) {

	global $DBH, $c, $user;

	try {
		$STH = $DBH->query('SELECT
				m.id AS id,
				m.parent AS parent,
				m.position AS position,
				m.title AS title,
				m.content AS content,
				c.id AS child,
				meta.meta_value AS special
			FROM
				'.PREFIX.'articles AS m
			LEFT JOIN
				'.PREFIX.'articles AS c
			ON
				m.id = c.parent AND
				c.type = "page"
			LEFT JOIN
				'.PREFIX.'meta AS meta
			ON
				m.id = meta.article AND
				meta.meta_key = "page_special"
			WHERE
				m.parent = "'.$parent.'" AND
				m.type = "page" AND
				m.status = "published"
			GROUP BY
				m.id
			ORDER BY m.position ASC
		');

		while ($m = $STH->fetch(PDO::FETCH_OBJ)) :
			if ($m->special == 'homepage') :
				$href = $c->ourl();
				$title = 'Home';
			elseif ($m->special == 'contacts') :
				$href = STR::url($c->ourl(), $m->special);
				$title = $m->title;
			elseif ($m->content != '' || $m->special != '') :
				$href = STR::url($c->ourl(), 'page', $m->id, $m->title);
				$title = $m->title;
			else :
				$href = '#';
				$title = $m->title;
			endif;

			echo '<li class="nav-item">';
			HTML::ctag('a', array(
				'class' => 'nav-link',
				'href'	=> $href
			), STR::o($title));

			if (isset($m->child)) {
				echo '<ul class="nav navbar-nav">';
				pagesMenuRecursive($m->id, $depth+1);
				echo '</ul>';
			}

			echo '</li>';
		endwhile;

		$depth = 0;
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}

}

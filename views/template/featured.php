<?php
if ($P->type == 'home') :
	try {
		$STH = $DBH->query('SELECT
				a.title AS title,
				a.subtitle AS subtitle,
				m2.meta_value AS meta_page,
				a.excerpt AS excerpt,
				a.featured_image AS featured_image,
				p.title AS page
			FROM
				'.PREFIX.'articles AS a,
				'.PREFIX.'meta AS m2,
				'.PREFIX.'articles AS p
			WHERE
				a.type = "featured" AND
				a.status = "published" AND
				a.id = m2.article AND
				m2.meta_key = "featured_page" AND
				m2.meta_value = p.id AND
				p.status = "published"
			ORDER BY a.position ASC LIMIT 5');
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$featArray = $STH->fetchAll();
		$featTot = count($featArray);
		if ($featTot > 0) :
			$i = 1;
?>

<div class="row p-b-1">
    <aside id="featured" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
                for ($i = 0; $i < $featTot; $i++) {
                    HTML::ctag('li', array(
                        'class'	=> $i == 0 ? 'active' : '',
                        'data-target' => '#featured',
                        'data-slide-to' => $i,
                    ), '');
                }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php $i = 0; foreach ($featArray as $feat) : ?>
                <div class="carousel-item<?php if ($i == 0) echo ' active'; ?>">
                    <img src="<?php
                        $c->url(); ?>uploads/featured/1280x720-<?php STR::e($feat->featured_image);
                    ?>">
                    <div class="carousel-caption">
                        <?php
                        HTML::ctag('h3', array(), STR::o($feat->title));
                        HTML::ctag('h4', array(
							'class' => 'hidden-sm-down'
						), STR::o($feat->subtitle));
                        HTML::ctag('p', array(
                            'class' => 'hidden-md-down'
                        ), STR::o($feat->excerpt));
                        ?>
                    </div>
                </div>
            <?php $i++; endforeach; ?>
        </div>
        <a class="left carousel-control" href="#featured" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#featured" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </aside>
</div>

<?php
        endif;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
endif;

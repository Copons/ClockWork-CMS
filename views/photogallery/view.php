<?php

try {
	$STH = $DBH->prepare('SELECT
		id, title, featured_image
	FROM
		'.PREFIX.'articles
	WHERE
		parent = :article AND
		type = "photogallery"
	ORDER BY position ASC');
	$STH->bindParam(':article', $P->id);
	$STH->execute();
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$pics = $STH->fetchAll();
	if (!empty($pics)) : ?>
<div class="p-y-2 clearfix">
<?php
	endif;

	foreach ($pics as $num => $pic) : ?>
	<div class="col-xs-6 col-sm-4 col-md-3 text-xs-center">
		<?php
		HTML::ctag('figure', array('class' => 'figure'),
			HTML::ctag('a', array(
				'href' => '#',
				'data-toggle' => 'modal',
				'data-target' => '#gallery-modal-'.$pic->id,
				'title'	=> STR::o($pic->title)
			),
				HTML::tag('img', array(
					'src' => $c->ourl().'uploads/photogallery/150x150-'.STR::o($pic->featured_image),
					'class' => 'figure-img img-fluid img-rounded center-block'
				), false)
			, false) .
				HTML::ctag('figcaption', array('class' => 'figure-caption'), STR::o($pic->title), false)
		);
		?>
		<div id="gallery-modal-<?php echo $pic->id ?>" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							&times;
						</button>
						<h4 class="modal-title">
							<?php STR::e($pic->title); ?>
						</h4>
					</div>
					<div class="modal-body">
						<img class="img-fluid center-block" src="<?php
							echo $c->ourl()
								. 'uploads/photogallery/'
								. STR::o($pic->featured_image);
						?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	endforeach;
	if (!empty($pics)) echo '</div>';
}
catch (PDOException $e) {
	echo $e->getMessage();
}
?>

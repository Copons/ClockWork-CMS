    <footer class="row p-a-1 text-xs-center text-muted">
        <?php $c->e('footer'); ?>
    </footer>

</div>

<?php
HTML::ctag('script', array(
	'type'	=> 'text/javascript',
	'src'	=> 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'
), true);

HTML::ctag('script', array(
	'type'	=> 'text/javascript',
	'src'	=> $c->ourl() . 'js/tether.min.js'
), true);

HTML::ctag('script', array(
	'type'	=> 'text/javascript',
	'src'	=> 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js'
), true);
?>
</body>
</html>

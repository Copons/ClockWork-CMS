<!DOCTYPE html>
<html dir="ltr" lang="en-EN">
<head>
<?php

HTML::tag('meta', array(
	'charset'	=> 'UTF-8'
));

HTML::tag('meta', array(
	'name'		=> 'viewport',
	'content'	=> 'initial-scale=1,width=device-width'
));

HTML::ctag('title', '', $P->pagetitle . $c->o('name'));

if (!isset($P->seo_description) || empty($P->seo_description))
	$desc = $c->o('description');
else
	$desc = STR::o($P->meta_description);
HTML::tag('meta', array(
	'name'		=> 'description',
	'content'	=> $desc
));

HTML::tag('link', array(
	'rel'	=> 'stylesheet',
	'type'	=> 'text/css',
	'media'	=> 'all',
	'href'	=> 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css'
));

?>

<script type="text/javascript">var URL = '<?php echo $c->ourl(); ?>';</script>

</head>
<body class="p-t-3">

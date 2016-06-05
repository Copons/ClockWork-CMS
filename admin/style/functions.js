$(document).ready(function(){




/* CLOCKWORK 2.4 POSITION RELATED AJAX FUNCTIONS */

var ajax = $('#ajax-data');

if (ajax.data('page') === 'pagine') {

	if (ajax.data('item') !== '') {
		$.get(
			'pages/'+ajax.data('page')+'/ajax.php',
			{
				parent:	$('select#parent').val(),
				item:	ajax.data('item')
			},
			function(data) {
				$('select#position').html(data);
			}
		);
	}

	$('select#parent').bind('change focus', function(){
		$.get(
			'pages/'+ajax.data('page')+'/ajax.php',
			{
				parent:	$(this).val(),
				item:	ajax.data('item')
			},
			function(data) {
				$('select#position').html(data);
				//ajax.html('<pre>X'+data+'</pre>');
			}
		);
	});

}
else if (ajax.data('page') === 'sponsor') {

	if (ajax.data('item') !== '') {
		$.get(
			'pages/'+ajax.data('page')+'/ajax.php',
			{
				type:	$('select#meta_type').val(),
				item:	ajax.data('item')
			},
			function(data) {
				$('select#position').html(data);
			}
		);
	}

	$('select#meta_type').bind('change focus', function(){
		$.get(
			'pages/'+ajax.data('page')+'/ajax.php',
			{
				type:	$(this).val(),
				item:	ajax.data('item')
			},
			function(data) {
				$('select#position').html(data);
				//ajax.html('<pre>X'+data+'</pre>');
			}
		);
	});

}




/* CLOCKWORK 2.4 PHOTOGALLERY RELATED AJAX FUNCTIONS */

$('#ajaxPhotogalleryUpload').click(function(e){
	e.preventDefault();
	alert($('#ajaxPhotogalleryFile').val());
});







$('.list-delete-button, .edit .delete').hover(function(){
	$('img',this).attr('src','images/delete.png');
}, function(){
	$('img',this).attr('src','images/delete-inactive.png');
});

$('.pg-list-delete-button').hover(function(){
	$('img',this).attr('src','../images/delete.png');
}, function(){
	$('img',this).attr('src','../images/delete-inactive.png');
});


$('.list-delete-button, .edit .delete a').fancybox();
$('.delete-close').click(function(){
	parent.$.fancybox.close();
});



if ($('#ok').length) {
	$('#ok').delay(2000).fadeTo('slow', 0.00, function(){
		$(this).slideUp('fast', function(){
			$(this).remove();
		});
	});
}
/*if ($('#error').length) {
	$('#error').delay(10000).fadeTo('slow', 0.00, function(){
		$(this).slideUp('fast', function(){
			$(this).remove();
		})
	});
}*/



$("a[rel='lightbox'], a[href$='.jpg'], a[href$='.jpeg'], a[href$='.gif'], a[href$='.png'], a[href$='.JPG'], a[href$='.JPEG'], a[href$='.GIF'], a[href$='.PNG']").fancybox({
	'zoomSpeedIn': 333,
	'zoomSpeedOut': 333,
	'zoomSpeedChange': 133,
	'easingIn': 'easeOutQuart',
	'easingOut': 'easeInQuart',
	'overlayShow' : true,
	'overlayColor': '#000',
	'overlayOpacity': '0.7'
});

$(".photogallery, .downloads").fancybox({
	type		: 'iframe',
	//maxWidth	: 800,
	//maxHeight	: 600,
	fitToView	: true,
	width		: '90%',
	height		: '90%',
	autoSize	: true,
	closeClick	: false,
	openEffect	: 'none',
	closeEffect	: 'none',
	'zoomSpeedIn': 333,
	'zoomSpeedOut': 333,
	'zoomSpeedChange': 133,
	'easingIn': 'easeOutQuart',
	'easingOut': 'easeInQuart',
	'overlayShow' : true,
	'overlayColor': '#000',
	'overlayOpacity': '0.7'});






}); // jQuery end
<?php

/*
singleHeader	($page, $title, $rowId, $name)
singleFooter	()
singleString	($title, $content, $isTitle, $link)
singleText		($title, $content)
singleDate		($title, $content)
singleImage		($title, $page, $title, $width, $height)
singleLastEdit	($datetime, $editor)
singleEdit		($page, $name)
*/




// SINGLE HEADER
//
// Opens the single content
// $page = the page in which will be used this function
// $title = the title of this page
// $rowId = the id of the shown item
// $name = the name of the shown item
function singleHeader ($page, $title, $rowId, $name) {

	?>
<h3><?php echo $title; ?>: <?php echo outputString($name); ?> &raquo;</h3>
<form enctype="multipart/form-data" method="post" action="<?php echo $page; ?>.php?action=edit&amp;ID=<?php echo $rowId; ?>">
<table class="edit">
	<?php

}




// SINGLE FOOTER
//
// Closes the single content
function singleFooter () {

	?>
</table>
</form>
	<?php

}




// SINGLE STRING
//
// Prints a simple string for the single content (already integrated in a <tr>)
// $title = field title
// $content = field content
// $isTitle = if TRUE, the content will be displayed inside a <h4>; FALSE by default
// $link = if set, links the string to an external page
function singleString ($title, $content, $isTitle = FALSE, $link = '', $newsletter = '') {

	if ($isTitle)
		$output = '<h4>';
	else
		$output = '';

	if ($link != '' && $newsletter == '')
		$output .= '<a href="' . outputString($link) . '"><img class="imgLink" src="images/link.png" alt="Link" /> ' . outputString($content) . '</a>';
	else if ($link == 'newsletter' && is_numeric($newsletter))
		$output .= '<span class="duplicate"><a href="pages/newsletter/send.php?ID=' . $newsletter . '"><img class="imgLink" src="images/send.png" alt="Invia questa newsletter" /> ' . outputString($content) . ' &raquo;</a></span>';
	else
		$output .= outputString($content);

	if ($isTitle)
		$output .= '</h4>';

	?>
<tr>
	<td class="name"><?php echo $title; ?></td>
	<td><?php echo $output; ?></td>
</tr>
	<?php

}




// SINGLE TEXT
//
// Prints a text for the single content (already integrated in a <tr>)
// $title = field title
// $content = field content
function singleText ($title, $content) {

	?>
<tr>
	<td class="name"><?php echo $title; ?></td>
	<td class="singleText"><?php echo outputString($content); ?></td>
</tr>
	<?php

}




// SINGLE DATE
//
// Prints a date for the single content (already integrated in a <tr>)
// $title = date title
// $content = date content (MySQL formatted)
function singleDate ($title, $content) {

	?>
<tr>
	<td class="name"><?php echo $title; ?></td>
	<td><?php echo dateITA($content); ?></td>
</tr>
	<?php

}




// SINGLE IMAGE
//
// Prints an image thumbnail for the single content
// $page = the page in which will be used this function
// $title = image title
// $url = image url
// $width = thumbnail width
// $height = thumbnail height
function singleImage ($title, $page, $url, $width, $height) {

	if ($url != '') :
		$thumb = imageThumb('../uploads/' . $page . '/' . $url, $width, $height);
		?>
<tr>
	<td class="name"><?php echo $title; ?></td>
	<td>
		<a href="../uploads/<?php echo $page; ?>/<?php echo $url; ?>" target="_blank">
			<img src="../uploads/<?php echo $page; ?>/<?php echo $url; ?>" alt="<?php echo $url; ?>" width="<?php echo $thumb['w']; ?>" height="<?php echo $thumb['h']; ?>" />
		</a>
	</td>
</tr>
		<?php
	else :
		?>
<tr>
	<td class="name"><?php echo $title; ?></td>
	<td></td>
</tr>
		<?php
	endif;

}




// SINGLE LAST EDIT
//
// Prints a Last Edit <tr>
// $datetime = MySQL formatted datetime
// $editor = editor id
function singleLastEdit ($datetime, $editor) {

	$queryEditor = 'SELECT username FROM '.PREFIX.'admin WHERE id = ' . $editor . ' LIMIT 1';
	$resultEditor = mysql_query($queryEditor) or die(mysql_error());
	$rowEditor = mysql_fetch_assoc($resultEditor);

	echo '<tr><td class="name">Last Edit</td><td>' . datetimeITA($datetime) . ' da <a href="admin.php?action=single&amp;ID=' . $editor . '"><img src="images/link.png" alt="Link" class="imgLink" /> ' . $rowEditor['nickname'] . '</td></td>';

}




// SINGLE EDIT
//
// Prints a <input> for editing the single content (already integrated in a <tr>)
// $page = if this element can be duplicated, set to the current page
// $name = if this element can be duplicated, set to this element name
function singleEdit ($page = '', $name = '', $rowId = '') {

	?>
<tr>
	<td class="submit"><input class="edit_button" id="edit" name="edit" type="submit" value="Modifica" /></td>
	<td><?php if($page != '' && ($page == 'NO_DUPLICATE')) : ?>
		<span class="duplicate"><a href="pages/<?php echo $page; ?>/duplicate.php?ID=<?php echo $rowId; ?>">
			<img class="imgDuplicate" src="images/duplicate.png" title="Duplicate" alt="Duplicate" /> Duplicate <strong><?php echo outputString($name); ?> &raquo;</strong>
		</a></span>
	<?php endif; ?></td>
</tr>
	<?php

}

?>

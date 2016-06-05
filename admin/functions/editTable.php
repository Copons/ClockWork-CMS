<?php

/*
editHeader		($page, $title, $rowId, $name)
editFooter		()
editInput		($name, $title, $content, $description, $required, $type, $size, $maxlength, $isTitle)
editTextarea	($name, $title, $content, $description, $required, $cols, $rows)
editFile		($name, $title, $description, $required, $maxfilesize, $page, $url)
editImage		($name, $title, $description, $required, $maxfilesize, $page, $url, $width, $height)
editDate		($name, $title, $content, $description, $required, $rangeFrom, $rangeTo)
editSelect 		($name, $title, $content, $description, $required, $arrayOptions)
editHidden		($name, $content)
editSave 		($page, $rowId, $name, $minLevel)
*/




// EDIT HEADER
//
// Opens the edit content
// $page = the page in which will be used this function
// $title = the title of this page
// $rowId = the id of the shown item
// $name = the name of the shown item
function editHeader ($page, $title, $rowId, $name) {

	?>
<!--<h3>Modifica <?php echo $title; ?>: <?php echo outputString($name); ?> &raquo;</h3>-->
<form enctype="multipart/form-data" method="post" action="pages/<?php echo $page; ?>/update.php?ID=<?php echo $rowId; ?>">
<div class="content-container">
<table class="edit">
	<?php

}




// EDIT FOOTER
//
// Closes the edit content
function editFooter () {

	?>
</table>
</div>
</form>
	<?php

}




// EDIT INPUT
//
// Prints a <input> for the edit form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $content = element content
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $type = <input> type attribute; if empty, is 'text' by default
// $size = <input> size attribute; if empty, is 50 by default
// $maxlength = <input> maxlength attribute; if empty, is 255 by default
// $isTitle = if TRUE, the content will be displayed as big as a <h4>; FALSE by default
function editInput ($name, $title, $content, $description, $required, $type, $size, $maxlength, $isTitle = FALSE) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($type == '') $type = 'text';
	if ($size == '') $size = '50';
	if ($maxlength != '') $maxlength = 'maxlength="' . $maxlength . '"';
	else $maxlength = 'maxlength="255"';
	if ($isTitle) $class = 'class="editTitle"';
	else $class = '';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><input <?php echo $class; ?>
				id="<?php echo $name; ?>"
				name="<?php echo $name; ?>"
				type="<?php echo $type; ?>"
				size="<?php echo $size; ?>"
				<?php echo $maxlength; ?>
				value="<?php echo outputString($content); ?>"
	/></td>
</tr>
	<?php

}




// EDIT TEXTAREA
//
// Prints a <textarea> for the edit form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $content = element content
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $cols = <textarea> cols attribute; if empty, is 70 by default
// $rows = <textarea> rows attribute; if empty, is 6 by default
function editTextarea ($name, $title, $content, $description, $required, $cols, $rows) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($cols == '') $type = '70';
	if ($rows == '') $size = '6';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><textarea id="<?php echo $name; ?>"
					name="<?php echo $name; ?>"
					cols="<?php echo $cols; ?>"
					rows="<?php echo $rows; ?>"><?php echo outputString($content); ?></textarea>
		<script type="text/javascript">
			//<![CDATA[
				var ckeditor = CKEDITOR.replace('<?php echo $name; ?>', {
												width : 600,
												height : 250,
												resize_maxWidth	: '100%',
												toolbar			: [
['Cut','Copy','Paste','PasteText','PasteFromWord'],
['-','Undo','Redo'],['-','Find','Replace'],['-','SelectAll','RemoveFormat'],
'/',
['Bold','Italic','Underline','Strike'],['-','Subscript','Superscript'],
['-','NumberedList','BulletedList'],['-','Outdent','Indent','Blockquote'],
['-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
'/',
['Link','Unlink','Anchor'],
['-','Image','Table','HorizontalRule','SpecialChar','PageBreak'],
['-','Source'],],
												filebrowserBrowseUrl : 'functions/ckBrowser.php',
												filebrowserImageBrowseUrl : 'functions/ckBrowser.php?type=immagine',
												filebrowserWindowWidth : '200',
        										filebrowserWindowHeight : '200'
												});
			//]]>
		</script>
	</td>
</tr>
	<?php

}




// EDIT IMAGE
//
// Prints a <input> for image upload for the edit form (already integrated in a <tr>)
// $name = field name
// $title = image title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $maxfilesize = <input> MAX_FILE_SIZE value attribute; if empty, is 2000000 (2MB) by default
// $page = the page in which will be used this function
// $url = image url
// $width = thumbnail width
// $height = thumbnail height
function editImage ($name, $title, $description, $required, $maxfilesize, $page, $url, $width, $height) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($maxfilesize == '') $maxfilesize = '2000000';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td>
	<?php
	if ($url != '') :
		$thumb = imageThumb('../uploads/' . $page . '/' . $url, $width, $height);
	?>
		<input type="hidden" id="<?php echo $name; ?>_old" name="<?php echo $name; ?>_old" value="<?php echo $url; ?>" />
		<a href="../uploads/<?php echo $page; ?>/<?php echo $url; ?>" target="_blank">
			<img src="../uploads/<?php echo $page; ?>/<?php echo $url; ?>" alt="<?php echo $url; ?>" width="<?php echo $thumb['w']; ?>" height="<?php echo $thumb['h']; ?>" />
		</a>
		&nbsp; Elimina Immagine: <input type="checkbox" id="delete_<?php echo $name; ?>" name="delete_<?php echo $name; ?>" value="<?php echo $url; ?>" />
		<br />
		<br />
	<?php
	endif;
	?>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize; ?>" />
		<input id="<?php echo $name; ?>"
				name="<?php echo $name; ?>"
				type="file"
		/>
	</td>
</tr>
	<?php

}




// EDIT FILE
//
// Prints a <input> for file upload for the edit form (already integrated in a <tr>)
// $name = field name
// $title = file title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $maxfilesize = <input> MAX_FILE_SIZE value attribute; if empty, is 2000000 (2MB) by default
// $page = the page in which will be used this function
// $url = image url
function editFile ($name, $title, $description, $required, $maxfilesize, $page, $url) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($maxfilesize == '') $maxfilesize = '2000000';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td>
	<?php
	if ($url != '') :
		echo '<a href="../uploads/' . $page . '/' . $url . '">' . $url . '</a><br /><br />';
	?>
		Elimina File: <input type="checkbox" id="delete_<?php echo $name; ?>" name="delete_<?php echo $name; ?>" value="<?php echo $url; ?>" />
		<br />
		<br />
	<?php
	endif;
	?>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize; ?>" />
		<input id="<?php echo $name; ?>"
				name="<?php echo $name; ?>"
				type="file"
		/>
	</td>
</tr>
	<?php

}





// EDIT DATE
//
// Prints a <select> for date selection for the edit form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $content = element content (MySQL formatted date)
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $rangeFrom = starting year, if empty is three years ago
// $rangeTo = ending year, if empty is three years in the future
// $page = the page in which will be used this function, needed for the cookie system
function editDate ($name, $title, $content, $description, $required, $rangeFrom, $rangeTo) {

	$today = time();
	$day = date('d', $today);
	$month = date('m', $today);
	$year = date('Y', $today);

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($rangeFrom == '') $rangeFrom = $year-3;
	if ($rangeTo == '') $rangeTo = $year+3;

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><select id="<?php echo $name; ?>Day" name="<?php echo $name; ?>Day"><option value=""></option>
		<?php
			for ($i = 1; $i <= 31; $i++) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,8,2)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Month" name="<?php echo $name; ?>Month"><option value=""></option>
		<?php
			for ($i = 1; $i <= 12; $i++) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,5,2)) echo ' selected="selected"';
				echo ' >' . monthITA($i) . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Year" name="<?php echo $name; ?>Year"><option value=""></option>
		<?php
			for ($i = $rangeTo; $i >= $rangeFrom; $i--) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,0,4)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select></td>
</tr>
	<?php

}





// EDIT DATETIME
//
// Prints a <select> for date selection for the edit form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $content = element content (MySQL formatted date)
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $rangeFrom = starting year, if empty is three years ago
// $rangeTo = ending year, if empty is three years in the future
// $page = the page in which will be used this function, needed for the cookie system
function editDatetime ($name, $title, $content, $description, $required, $rangeFrom, $rangeTo) {

	$today = time();
	$day = date('d', $today);
	$month = date('m', $today);
	$year = date('Y', $today);
	$hour = date('H', $today);
	$minute = date('i', $today);

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($rangeFrom == '') $rangeFrom = $year-3;
	if ($rangeTo == '') $rangeTo = $year+3;

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><select id="<?php echo $name; ?>Day" name="<?php echo $name; ?>Day"><option value=""></option>
		<?php
			for ($i = 1; $i <= 31; $i++) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,8,2)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Month" name="<?php echo $name; ?>Month"><option value=""></option>
		<?php
			for ($i = 1; $i <= 12; $i++) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,5,2)) echo ' selected="selected"';
				echo ' >' . monthITA($i) . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Year" name="<?php echo $name; ?>Year"><option value=""></option>
		<?php
			for ($i = $rangeTo; $i >= $rangeFrom; $i--) :
				echo '<option value="' . $i . '"';
				if ($i == substr($content,0,4)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select> &nbsp;  &nbsp; &nbsp;
	<select id="<?php echo $name; ?>Hour" name="<?php echo $name; ?>Hour"><option value=""></option>
		<?php
			for ($i = 0; $i <= 23; $i++) :
				if(strlen($i) == 1) $i = '0'.$i;
				echo '<option value="' . $i . '"';
				if ($i == substr($content,11,2)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select> :
	<select id="<?php echo $name; ?>Minute" name="<?php echo $name; ?>Minute"><option value=""></option>
		<?php
			for ($i = 0; $i <= 59; $i++) :
				if(strlen($i) == 1) $i = '0'.$i;
				echo '<option value="' . $i . '"';
				if ($i == substr($content,14,2)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select>
	</td>
</tr>
	<?php

}




// EDIT SELECT
//
// Prints a <select> for the edit form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $content = element content
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $arrayOptions = <option> keys => values
// $ajax = a javascript function executed onchange
function editSelect ($name, $title, $content, $description, $required, $arrayOptions, $ajax = '') {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($ajax != '') $ajax = ' onchange="' . $ajax . '"';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><select id="<?php echo $name; ?>" name="<?php echo $name; ?>"<?php echo $ajax; ?>><option value=""></option>
		<?php
			foreach ($arrayOptions as $key => $value) :
				echo '<option value="' . $key . '"';
				if (outputString($content) == $key) echo ' selected="selected"';
				echo '>' . $value . '</option>';
			endforeach;
		?>
	</select></td>
</tr>
	<?php

}




// EDIT HIDDEN
//
// Prints a hidden <input> for the edit form (not integrated in a <tr>)
// $name = field name
// $content = element content
function editHidden ($name, $content) {

	?>
<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="hidden" value="<?php echo outputString($content); ?>" />
	<?php

}





// EDIT SAVE
//
// Prints a <input> for submitting or deleting for the edit form (already integrated in a <tr>)
// $page = the page in which will be used this function
// $rowId = element id
// $name = element name
// $minLevel = a comma separated list of levels needed to access to this page; no level needed by default
function editSave ($page, $rowId, $name, $minLevel = '') {

	?>
<tr>
	<td class="name submit"><input id="save" name="save" type="submit" value="Salva" /></td>
	<td class="required"></td>
	<td><?php if($page != 'config' && checkLevel($minLevel, 'item')) : ?>
		<span class="delete"><a<?php /* onclick="if(confirm('Proseguire con l\'eliminazione?'))window.location='pages/<?php echo $page; ?>/delete.php?ID=<?php echo $rowId; ?>'"*/ ?> href="#delete-<?php echo $rowId; ?>">
			<img class="imgDelete" src="images/delete-inactive.png" title="Elimina" alt="Elimina" /> Delete <strong><?php echo outputString($name); ?> &raquo;</strong>
		</a></span>
		<div style="display:none"><div class="list-delete-alert" id="delete-<?php echo $rowId; ?>">
		<p><strong>Warning!</strong></p>
		<p>This action is permanent.</p>
		<p>Proceed?</p>
		<a href="pages/<?php echo $page; ?>/delete.php?ID=<?php echo $rowId; ?>" style="color: red;">Yes</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="#" class="delete-close">No</a>
	</div></div>
	<?php endif; ?></td>
</tr>
	<?php

}





// EDIT GALLERY
//
function editGallery ($pageID, $maxfilesize = '') {

	if ($maxfilesize == '') $maxfilesize = '2000000';

	?>
<tr>
	<td class="name">Photogallery</td>
	<td class="required"></td>
	<td>
		<a
			class="photogallery fancybox.iframe"
			href="functions/photogallery.php?pageID=<?php echo $pageID; ?>&maxfilesize=<?php echo $maxfilesize; ?>"
			>Manage the gallery for this element.</a>
	</td>
</tr>
	<?php

}

?>

<?php

/*
insertHeader	($page, $description)
insertFooter	()
insertInput 	($name, $title, $description, $required, $type, $size, $maxlength, $page, $isTitle)
insertTextarea 	($name, $title, $description, $required, $cols, $rows, $page)
insertFile 		($name, $title, $description, $required, $maxfilesize)
insertDate 		($name, $title, $description, $required, $rangeFrom, $rangeTo, $page)
insertSelect 	($name, $title, $description, $required, $arrayOptions, $page)
insertRadio		($name, $title, $description, $required, $arrayOptions, $page)
insertSave 		()
*/




// INSERT HEADER
//
// Opens the insert content
// $page = the page in which will be used this function
// $description = a brief description of this form
function insertHeader ($page, $description) {

	?>
<!--<h3><?php echo $description; ?></h3>-->
<form enctype="multipart/form-data" method="post" action="pages/<?php echo $page; ?>/save.php">
<div class="content-container">
<table class="edit">
	<?php

}




// INSERT FOOTER
//
// Closes the insert content
function insertFooter () {

	?>
</table>
</div>
</form>
	<?php

}




// INSERT INPUT
//
// Prints a <input> for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $type = <input> type attribute; if empty, is 'text' by default
// $size = <input> size attribute; if empty, is 50 by default
// $maxlength = <input> maxlength attribute; if empty, is 255 by default
// $page = the page in which will be used this function, needed for the cookie system
// $isTitle = if TRUE, the content will be displayed as big as a <h4>; FALSE by default
function insertInput ($name, $title, $description, $required, $type, $size, $maxlength, $page, $isTitle = FALSE) {

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
				<?php if(isset($_COOKIE['tmp_' . $page . '_' . $name])) echo 'value="' . outputString($_COOKIE['tmp_' . $page . '_' . $name]) . '" '; ?>
	/></td>
</tr>
	<?php

}




// INSERT TEXTAREA
//
// Prints a <textarea> for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $cols = <textarea> cols attribute; if empty, is 70 by default
// $rows = <textarea> rows attribute; if empty, is 6 by default
// $page = the page in which will be used this function, needed for the cookie system
function insertTextarea ($name, $title, $description, $required, $cols, $rows, $page) {

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
					rows="<?php echo $rows; ?>"><?php if(isset($_COOKIE['tmp_' . $page . '_' . $name])) echo outputString(outputString(outputString($_COOKIE['tmp_' . $page . '_' . $name]))); ?></textarea>
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




// INSERT FILE
//
// Prints a <input> for file upload for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $maxfilesize = <input> MAX_FILE_SIZE value attribute; if empty, is 2000000 (2MB) by default
function insertFile ($name, $title, $description, $required, $maxfilesize) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';
	if ($maxfilesize == '') $maxfilesize = '2000000';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize; ?>" />
	<input id="<?php echo $name; ?>"
			name="<?php echo $name; ?>"
			type="file"
	/></td>
</tr>
	<?php

}




// INSERT DATE
//
// Prints a <select> for date selection for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $rangeFrom = starting year, if empty is three years ago
// $rangeTo = ending year, if empty is three years in the future
// $page = the page in which will be used this function, needed for the cookie system
function insertDate ($name, $title, $description, $required, $rangeFrom, $rangeTo, $page) {

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
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], -2, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $day)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Month" name="<?php echo $name; ?>Month"><option value=""></option>
		<?php
			for ($i = 1; $i <= 12; $i++) :
				echo '<option value="' . $i . '"';
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 5, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $month)) echo ' selected="selected"';
				echo ' >' . monthITA($i) . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Year" name="<?php echo $name; ?>Year"><option value=""></option>
		<?php
			for ($i = $rangeTo; $i >= $rangeFrom; $i--) :
				echo '<option value="' . $i . '"';
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 0, 4)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $year)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select></td>
</tr>
	<?php

}




// INSERT DATETIME
//
// Prints a <select> for datetime selection for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $rangeFrom = starting year, if empty is three years ago
// $rangeTo = ending year, if empty is three years in the future
// $page = the page in which will be used this function, needed for the cookie system
function insertDatetime ($name, $title, $description, $required, $rangeFrom, $rangeTo, $page) {

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
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 8, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $day)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Month" name="<?php echo $name; ?>Month"><option value=""></option>
		<?php
			for ($i = 1; $i <= 12; $i++) :
				echo '<option value="' . $i . '"';
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 5, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $month)) echo ' selected="selected"';
				echo ' >' . monthITA($i) . '</option>';
			endfor;
		?>
		</select> &frasl;
		<select id="<?php echo $name; ?>Year" name="<?php echo $name; ?>Year"><option value=""></option>
		<?php
			for ($i = $rangeTo; $i >= $rangeFrom; $i--) :
				echo '<option value="' . $i . '"';
				if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 0, 4)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $year)) echo ' selected="selected"';
				echo ' >' . $i . '</option>';
			endfor;
		?>
	</select> &nbsp;  &nbsp; &nbsp;
	<select id="<?php echo $name; ?>Hour" name="<?php echo $name; ?>Hour"><option value=""></option>
	<?php
		for ($i = 0; $i <= 23; $i++) :
			if(strlen($i) == 1) $i = '0'.$i;
			echo '<option value="' . $i . '"';
			if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 11, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $hour)) echo ' selected="selected"';
			echo ' >' . $i . '</option>';
		endfor;
	?>
	</select> :
	<select id="<?php echo $name; ?>Minute" name="<?php echo $name; ?>Minute"><option value=""></option>
	<?php
		for ($i = 0; $i <= 59; $i++) :
			if(strlen($i) == 1) $i = '0'.$i;
			echo '<option value="' . $i . '"';
			if ((isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == substr($_COOKIE['tmp_' . $page . '_' . $name], 14, 2)) || (!isset($_COOKIE['tmp_' . $page . '_' . $name]) && $i == $minute)) echo ' selected="selected"';
			echo ' >' . $i . '</option>';
		endfor;
	?>
	</select></td>
</tr>
	<?php

}




// INSERT SELECT
//
// Prints a <select> for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $arrayOptions = <option> keys => values
// $page = the page in which will be used this function, needed for the cookie system
function insertSelect ($name, $title, $description, $required, $arrayOptions, $page) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><select id="<?php echo $name; ?>" name="<?php echo $name; ?>"><option value=""></option>
		<?php
			foreach ($arrayOptions as $key => $value) :
				echo '<option value="' . $key . '"';
				if (isset($_COOKIE['tmp_' . $page . '_' . $name]) && $_COOKIE['tmp_' . $page . '_' . $name] == $key)echo ' selected="selected"';
				echo '>' . $value . '</option>';
			endforeach;
		?>
	</select></td>
</tr>
	<?php

}




// INSERT RADIO
//
// Prints a radio button <input> for the insert form (already integrated in a <tr>)
// $name = field name
// $title = field title
// $description = if it's not empty, print a small description of the field
// $required = if it's not empty, print a "required" star next to the title
// $arrayOptions = <option> keys => values
// $page = the page in which will be used this function, needed for the cookie system
function insertRadio ($name, $title, $description, $required, $arrayOptions, $page) {

	if ($description != '') $description = '<br /><span class="help">' . $description . '</span>';
	if ($required != '') $required = '*';

	?>
<tr>
	<td class="name"><?php echo $title . $description; ?></td>
	<td class="required"><?php echo $required; ?></td>
	<td><?php /* TO COMPLETE */ ?></td>
</tr>
	<?php

}




// INSERT SAVE
//
// Prints a <input> for submitting for the insert form (already integrated in a <tr>)
function insertSave () {

	?>
<tr>
	<td class="name submit"><input id="save" name="save" type="submit" value="Save" /></td>
	<td class="required"></td>
	<td></td>
</tr>
	<?php

}

?>

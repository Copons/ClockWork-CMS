<?php

/*
altRowBG			($trClass)
reorderArray		($orderArray)
orderByString		($orderArray)
directionArrow		($field, $orderArray)
switchOrder			($field)
viewHeader			($page, $headerArray, $orderArray, $minLevel, $logs)
viewServices		($page, $title, $rowId, $rowBg, $minLevel, $logs)
viewString			($string, $class, $bold, $link)
viewImage			($page, $class, $url, $width, $height)
viewLastEdit		($datetime, $editor)
viewFooter			()
viewPagingString	($rowsPerPage)
viewPaging			($page, $tot, $rowsPerPage)
*/




// ALT ROW BG
//
// Alternates table row background
// $trClass = bright or dark
function altRowBG ($trClass) {

	if ($trClass != 'bright' && $trClass != 'dark')
		$trClass = 'dark';

	if ($trClass == 'bright')
		$trClass = 'dark';
	else
		$trClass = 'bright';

	return $trClass;
}




// REORDER ARRAY
//
// Return an array ordered as requested
// $orderArray = array containing fields and directions
function reorderArray ($orderArray) {

	$newOrderArray = array();

	if ((isset($_REQUEST['order']) && isset($_REQUEST['dir'])) &&
		($_REQUEST['dir'] == 'ASC' || $_REQUEST['dir'] == 'DESC') &&
		(array_key_exists($_REQUEST['order'], $orderArray)))
		$newOrderArray[$_REQUEST['order']] = $_REQUEST['dir'];

	foreach ($orderArray as $field => $direction)
		if (isset($_REQUEST['order']) && $_REQUEST['order'] == $field)
			{ /* Do nothing! */ }
		else
			$newOrderArray[$field] = $direction;

	return $newOrderArray;

}




// ORDER BY STRING
//
// Returns a MySQL "ORDER BY" string
// $orderArray = array containing fields and directions
function orderByString ($orderArray) {

	$orderString = 'ORDER BY ';

	foreach ($orderArray as $field => $direction)
		$orderString .= $field . ' ' . $direction . ', ';

	if (substr($orderString, -2, 2) == ', ')
		$orderString = substr($orderString, 0, -2);

	return $orderString;

}




// DIRECTION ARROW
//
// Prints an <img> of an arrow that shows the table order direction
// $field = the field whom the arrow refers to
// $orderArray = array containing fields and directions
function directionArrow ($field, $orderArray) {

	if ((isset($_REQUEST['order']) && isset($_REQUEST['dir'])) &&
		($_REQUEST['dir'] == 'ASC' || $_REQUEST['dir'] == 'DESC') &&
		(array_key_exists($_REQUEST['order'], $orderArray))) :
		$order = $_REQUEST['order'];
		$direction = $_REQUEST['dir'];
	else :
		$order = '';
		$direction = '';
	endif;

	if ($direction == 'ASC')
		$alt = 'Ascending';
	else if ($direction == 'DESC')
		$alt = 'Descending';

	if ($order == $field)
		echo '&nbsp;&nbsp;<img src="images/' . $direction . '.png" alt="' . $alt . '" />';
		//echo ' <span style="color: #000">&uarr;</span>';

}




// SWITCH ORDER
//
// Switch the direction of the requested field in the ordering link url
// $field = the field whom the url refers to
function switchOrder ($field) {

	if (isset($_REQUEST['order']) && isset($_REQUEST['dir']) &&
		$_REQUEST['dir'] == 'ASC' &&
		$field == $_REQUEST['order'])
		echo 'DESC';
	else if (isset($_REQUEST['order']) && isset($_REQUEST['dir']) &&
			 $_REQUEST['dir'] == 'DESC' &&
			 $field == $_REQUEST['order'])
		echo 'ASC';
	else
		echo 'ASC';

}




// VIEW HEADER
//
// Opens the view content
// $page = the page in which will be used this function
// $headerArray = array containing field slugs as keys and field names as values
// $orderArray = array containing fields and directions
// $minLevel = a comma separated list of levels needed to access to this page; no level needed by default
// $logs = TRUE only if this is the header for the logs page
function viewHeader ($page, $headerArray, $orderArray, $minLevel = '', $logs = FALSE) {

	?>
	<div class="content-container">
<table class="list">
	<tr>
	<?php

	foreach ($headerArray as $slug => $name) :
		?>
		<th<?php if ($slug == 'id') echo ' class="small"'; ?>>
		<?php if (array_key_exists($slug, $orderArray)) : ?>
			<a href="<?php echo $page; ?>.php?order=<?php echo $slug; ?>&amp;dir=<?php switchOrder($slug); ?>">
				<?php echo $name; directionArrow($slug, $orderArray); ?>
			</a>
		</th>
		<?
		else :
			echo $name;
		endif;
	endforeach;
	 if ($logs == FALSE) : ?>
		<?php /* if($page != 'config') : ?><th title="Visualizza" class="small"></th><?php endif; ?>
		<th title="Modifica" class="small"></th>
		<?php */ if($page != 'config' && checkLevel($minLevel, 'item')) : ?><th title="Elimina" class="small"></th><?php endif; ?>
	<?php endif;

	echo '</tr>';

}




// VIEW SERVICES
//
// Prints single, edit and delete <td>s
// $page = the page in which will be used this function
// $title = the title of the page
// $rowId = the id of the current record
// $rowBg = class for the row background
// $minLevel = a comma separated list of levels needed to access to this page; no level needed by default
// $logs = TRUE only if this is the header for the logs page
function viewServices ($page, $title, $rowId, $rowBg, $minLevel = '', $logs = FALSE) {

	if($page != 'config' && checkLevel($minLevel, 'item')) : ?>
		<td class="service">
			<a href="#delete-<?php echo $rowId; ?>" class="list-delete-button">
				<img src="images/delete-inactive.png" title="Elimina <?php echo $title; ?>" alt="Elimina <?php echo $title; ?>" />
			</a>
			<div style="display:none"><div class="list-delete-alert" id="delete-<?php echo $rowId; ?>">
				<p><strong>Warning!</strong></p>
				<p>This action is permanent.</p>
				<p>Proceed?</p>
				<a href="pages/<?php echo $page; ?>/delete.php?ID=<?php echo $rowId; ?>" style="color: red;">Yes</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="#" class="delete-close">No</a>
			</div></div>
		</td>
	<?php endif;

}




// VIEW STRING
//
// Prints a simple <td> with a string
// $string = the string to print
// $class = if set, use a custom class for the <td>
// $bold = if is 'b', print the string in bold weight
// $link = if set, links the string to an external page
function viewString ($string, $class = '', $bold = '', $page = '', $id = '', $link = '') {

	$string = outputString($string);

	if ($bold == 'b')
		$string = '<strong>' . $string . '</strong>';

	if ($page != '' && $id != '' && is_numeric($id)) :
		$string_tmp = '<a href="' . $page . '.php?action=edit&amp;ID=' . $id;
		if (isset($_GET['lavoro']) && is_numeric($_GET['lavoro'])) $string_tmp .= '&amp;lavoro='.$_GET['lavoro'];
		$string_tmp .= '" class="element-title">' . $string . '&nbsp;<span>&rarr;</span></a>';
		$string = $string_tmp;

	elseif ($link != '') :
		$string = '<a href="' . outputString($link) . '"><img src="images/link.png" alt="Link" /> ' . $string . '</a>';

	endif;

	echo '<td';

	if ($class != '')
		echo ' class="' . $class . '"';

	echo '>' . $string . '</td>';

}




// VIEW IMAGE
//
// Prints a <td> with an image thumbnail inside
// $page = the page in which will be used this function
// $class = if set, use a custom class for the <td>
// $url = image url
// $width = thumbnail width
// $height = thumbnail height
function viewImage ($page, $class, $url, $width, $height, $thumbprefix = '') {

	if ($url != '') :
		if ($thumbprefix == '') :
			$thumb = imageThumb('../uploads/' . $page . '/' . $url, $width, $height);
			$thumbnail = $url;
		else :
			$thumb = imageThumb('../uploads/' . $page . '/' . $thumbprefix . $url, $width, $height);
			$thumbnail = $thumbprefix.$url;
		endif;
		?>
<td<?php if ($class != '') echo ' class="' . $class . '"' ?>>
	<a href="../uploads/<?php echo $page; ?>/<?php echo $url; ?>" target="_blank">
		<img src="../uploads/<?php echo $page; ?>/<?php echo $thumbnail; ?>" alt="<?php echo $url; ?>" width="<?php echo $thumb['w']; ?>" height="<?php echo $thumb['h']; ?>" />
	</a>
</td>
		<?php
	else :
		echo '<td></td>';
	endif;

}




// VIEW SOCIAL SHARING
//
function viewSocialSharing ($title, $permalink) {
	?>
<td>
	<div class="fb-like" data-href="<?php echo $permalink; ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $permalink; ?>" data-text="<?php echo outputString($title) . ' ' . $config['site_name']; ?>" data-count="none">Tweet</a>
</td>
	<?php
}
function toSlug($phrase, $maxLength=45) {
	$result = strtolower($phrase);
	$result = preg_replace("/[^a-z0-9\s-]/", "", $result);
	$result = trim(preg_replace("/[\s-]+/", " ", $result));
	$result = preg_replace("/\s/", "-", $result);
	return $result;
}



// VIEW LAST EDIT
//
// Prints a Last Edit <td>
// $datetime = MySQL formatted datetime
// $editor = editor id
function viewLastEdit ($datetime, $editor) {

	$queryEditor = 'SELECT username FROM '.PREFIX.'admin WHERE id = ' . $editor . ' LIMIT 1';
	$resultEditor = mysql_query($queryEditor) or die(mysql_error());
	$rowEditor = mysql_fetch_assoc($resultEditor);

	echo '<td>' . datetimeITA($datetime, '.') . ' by <a href="admin.php?action=single&amp;ID=' . $editor . '"><img src="images/link.png" alt="Link" /> ' . $rowEditor['username'] . '</a></td>';

}




// VIEW FOOTER
//
// Closes the view content
function viewFooter () {

	?>
</tr>
</table>
	<?php

}




// VIEW PAGING STRING
//
// Creates a MySQL LIMIT pagination string
// $rowsPerPage = number of rows to be shown on a single page
function viewPagingString ($rowsPerPage) {

	if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0) :
		$start = ((cleanString(intval($_REQUEST['page'])) - 1) * $rowsPerPage);
		return 'LIMIT ' . $start . ', ' . $rowsPerPage;
	else :
		return 'LIMIT 0,'. $rowsPerPage;
	endif;

}




// VIEW PAGING
//
// Prints a paging table
// $page = the page in which will be used this function
// $tot = result of COUNT(*) in the SELECT query
// $rowsPerPage = number of rows to be shown on a single page
function viewPaging ($page, $tot, $rowsPerPage, $footer = '') {

	$pageTot = intval(intval($tot) / $rowsPerPage);
	if ($tot % $rowsPerPage > 0) $pageTot++;

	if ($pageTot > 1) :

		?>
<div class="<?php if ($footer!='') echo 'paging-footer'; else echo 'paging'; ?>">
		<?php

		if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0)
			$pageNum = cleanString(intval($_REQUEST['page']));
		else
			$pageNum = 1;

		$urlVars = '';
		if (isset($_REQUEST['order']) || isset($_REQUEST['dir'])) :
			if (isset($_REQUEST['order']))
				$urlVars .= 'order=' . cleanString($_REQUEST['order']) . '&amp;';
			if (isset($_REQUEST['dir']))
				$urlVars .= 'dir=' . cleanString($_REQUEST['dir']) . '&amp;';
		endif;

		for ($i = 1; $i <= $pageTot; $i++) :
			echo '<a href="' . $page . '.php?page=' . $i . '&amp;' . $urlVars . '" title="Pagina ' . $i . '">';
			if ($i == $pageNum)
				echo '<strong>' . $i . '</strong>';
			else
				echo $i;
			echo '</a>';
			if ($i < $pageTot)
				echo ' | ';
		endfor;

		?>
</div>
		<?php

	endif;

}

?>

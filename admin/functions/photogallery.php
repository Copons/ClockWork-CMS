<?php

session_start();

require('../include/config.inc.php');
require('../include/errors.inc.php');

require('../functions/mysql.php');
MySQLconnectW();

require('../include/info.inc.php');
require('../functions/support.php');
require('../functions/advices.php');
require('../functions/login.php');
require('../functions/strings.php');
require('../functions/upload.php');

require('../functions/process.php');
require('../functions/log.php');

if (!isset($noCheckLogin))
	checkLogin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Jacopo Tomasone" />
<meta name="copyright" content="H25 Media Agency" />
<script src="../style/jquery-1.6.2.min.js"></script>
<script src="../style/functions.js?rand=783"></script>
<title>Upload</title>
<link href="../style/cw3.css" rel="stylesheet" type="text/css" media="all" />
<style>

#menu { margin: 0; }
h3 { margin: 0; }
#mainContent { padding: 0 10px 20px 10px; }

.gallery {
	border-top: 1px solid #ccc;
	text-align: center;
}
.gallery td {
	position: relative;
	width: 16.5%;
	border-left: 1px solid #ccc;
	border-right: 1px solid #ccc;
	vertical-align: top;
}
.gallery td:first-child, .gallery td:last-child {
	border-left: none;
	border-right: none;
}
.gallery .thumb {
	width: 100px;
	height: 100px;
}
.pg-list-delete-button {
	position: absolute;
	top: 3px;
	right: 3px;
}

</style>
</head>

<body>
<nav id="menu" class="clear"><h3>Photogallery</h3></nav>
<section id="mainContent">
<div class="content-container">

<?php if (!isset($_REQUEST['pic']) || !is_numeric($_REQUEST['pic'])) : ?>

<form enctype="multipart/form-data" method="post" action="photogalleryUpload.php?ID=<?php echo $_REQUEST['pageID']; ?>&action=upload">
<table class="edit">
	<tr>
		<td class="name">Title</td>
		<td><input
					id="title"
					name="title"
					type="text"
					size="50"
					maxlength="255"
		/></td>
	</tr>
	<tr>
		<td class="name">Load Image<br /><small>(Max 2 MB)</small></td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_REQUEST['maxfilesize']; ?>" />
			<input type="file" id="upload" name="upload" />
		</td>
	</tr>
	<tr>
		<td class="name">Position</td>
		<td><select id="position" name="position">
			<?php

$arrayPosition = array();
$qPos = 'SELECT position, title FROM '.PREFIX.'articles WHERE type = "photogallery" AND parent = "'.cleanString($_REQUEST['pageID']).'" ORDER BY position ASC';
$rPos = mysql_query($qPos) or die(mysql_query());
if (mysql_num_rows($rPos) == 0) :
	$arrayPosition[1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;

$i = 1;
$posCount = count($arrayPosition);

				foreach ($arrayPosition as $key => $value) :
					echo '<option value="' . $key . '"';
					if ($i == $posCount) echo ' selected="selected"';
					echo '>' . $value . '</option>';
					$i++;
				endforeach;
			?>
		</select></td>
	</tr>
	<tr>
		<td class="name submit">
			<input id="save" name="save" type="submit" value="Upload" />
		</td>
		<td></td>
	</tr>
	<tr>
		<table class="edit gallery">
<?php
	$q = 'SELECT
		a.id AS id,
		a.title AS title,
		a.featured_image AS featured_image,
		a.position AS position
	FROM
		'.PREFIX.'articles AS a
	WHERE
		a.type = "photogallery" AND
		a.parent = "'.cleanString($_REQUEST['pageID']).'"
	ORDER BY
		a.position ASC';
	$r = mysql_query($q) or die(mysql_error());
	$i = 1;
	while ($pic = mysql_fetch_assoc($r)) :
		if ($i == 1) echo '<tr>';
?>
		<td>
			<a href="photogallery.php?pageID=<?php echo $_REQUEST['pageID']; ?>&pic=<?php echo $pic['id']; ?>">
				<img src="../../uploads/photogallery/150x150-<?php echo $pic['featured_image']; ?>" class="thumb" />
				<br /><?php echo outputString($pic['position']); ?>
				<br /><?php echo outputString($pic['title']); ?>
				<br /><a href="photogalleryUpload.php?ID=<?php echo $_REQUEST['pageID']; ?>&pic=<?php echo $pic['id']; ?>&action=delete" class="pg-list-delete-button"><img src="../images/delete-inactive.png" />
			</a>
		</td>
<?php
		if ($i == 6) :
			$i = 1;
			echo '</tr>';
		else :
			$i++;
		endif;
	endwhile;
	if ($i != 6) :
		for ($j = $i; $j <= 6; $j++) :
			echo '<td></td>';
		endfor;
		echo '</tr>';
	endif;
?>
		</table>
	</tr>
</table>
</form>

<?php else :
	$q = 'SELECT id, title, position, featured_image FROM '.PREFIX.'articles WHERE id="'.cleanString($_REQUEST['pic']).'" LIMIT 1';
	$r = mysql_query($q) or die(mysql_error());
	$pic = mysql_fetch_assoc($r);
?>

<form enctype="multipart/form-data" method="post" action="photogalleryUpload.php?ID=<?php echo $_REQUEST['pageID']; ?>&pic=<?php echo $pic['id']; ?>&action=update">
<table class="edit">
	<tr>
		<td class="name">Immagine</td>
		<td>
			<a href="../../uploads/photogallery/<?php echo $pic['featured_image']; ?>" target="_blank
				">
				<img src="../../uploads/photogallery/150x150-<?php echo $pic['featured_image']; ?>" />
			</a>
		</td>
	</tr>
	<tr>
		<td class="name">Title</td>
		<td><input
					id="title"
					name="title"
					type="text"
					size="50"
					maxlength="255"
					value="<?php echo outputString($pic['title']); ?>"
		/></td>
	</tr>
	<tr>
		<td class="name">Position</td>
		<td><select id="position" name="position">
			<?php

$arrayPosition = array();
$qPos = 'SELECT position, title FROM '.PREFIX.'articles WHERE type = "photogallery" AND parent = "'.cleanString($_REQUEST['pageID']).'" AND id != "'.$pic['id'].'" ORDER BY position ASC';
$rPos = mysql_query($qPos) or die(mysql_query());
if (mysql_num_rows($rPos) == 0) :
	$arrayPosition[1] = 'At the beginning';
else :
	while ($pos = mysql_fetch_assoc($rPos)) :
		$arrayPosition[$pos['position']] = 'Before "' . outputString($pos['title']) . '"';
	endwhile;
	$arrayPosition[] = 'At the end';
endif;

$i = 1;
$posCount = count($arrayPosition);

				foreach ($arrayPosition as $key => $value) :
					echo '<option value="' . $key . '"';
					if ($i == $pic['position']) echo ' selected="selected"';
					echo '>' . $value . '</option>';
					$i++;
				endforeach;
			?>
		</select></td>
	</tr>
	<tr>
		<td class="name submit">
			<input id="save" name="save" type="submit" value="Save" />
		</td>
		<td></td>
	</tr>
</table>
</form>

<?php endif; ?>

</div>
</section>
<?php require('../sections/footer.php'); ?>

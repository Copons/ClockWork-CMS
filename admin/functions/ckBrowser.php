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

$ckEditor = $_GET['CKEditor'];
$ckFunction = $_GET['CKEditorFuncNum'];

if (isset($_GET['type']) && $_GET['type'] == 'immagine')
	$type = 'immagine';
else
	$type = 'file';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Jacopo Tomasone" />
<meta name="copyright" content="H25 Media Agency" />
<title>Upload</title>
<link href="../style/cw3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<nav id="menu" class="clear" style="margin:0"><h3 style="margin:0">Upload</h3></nav>
<section id="mainContent" style="padding:0 10px 20px 10px">
<div class="content-container">
<form enctype="multipart/form-data" method="post" action="ckUpload.php?ckEditor=<?php echo $ckEditor; ?>&amp;ckFunction=<?php echo $ckFunction; ?>&amp;type=<?php echo $type; ?>">
<table class="edit">
	<tr>
		<td class="name">Upload file <?php echo $type; ?><br /><small>(Max 2 MB)</small></td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<input type="file" id="upload" name="upload" />
		</td>
	</tr>
	<tr>
		<td class="submit">
			<input id="save" name="save" type="submit" value="Upload" />
		</td>
		<td></td>
	</tr>
</table>
</form>

</div>
</section>
<?php require('../sections/footer.php'); ?>

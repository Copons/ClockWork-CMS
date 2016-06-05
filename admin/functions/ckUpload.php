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

$ckEditor = $_GET['ckEditor'];
$ckFunction = $_GET['ckFunction'];

if (isset($_GET['type']) && $_GET['type'] == 'immagine')
	$callback = ckImageUpload($_FILES['upload'], $DBcfg['url']);
else
	$callback = ckFileUpload($_FILES['upload'], $DBcfg['url']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Jacopo Tomasone" />
<meta name="copyright" content="H25 Media Agency" />
<title>Upload</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body>
<script type="text/javascript">
//<![CDATA[
	window.opener.CKEDITOR.tools.callFunction(<?php echo $ckFunction; ?>, "<?php echo $callback['url']; ?>", "<?php echo $callback['msg']; ?>");
	window.close();
//]]>
</script>
</body>
</html>
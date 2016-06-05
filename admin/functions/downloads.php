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
<title>Totale Download</title>
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
<?php
$query = 'SELECT * FROM '.PREFIX.'articles WHERE id = ' . cleanString($_REQUEST['pageID']) . ' AND type = "downloads" LIMIT 1';
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
?>
<nav id="menu" class="clear"><h3><?php echo outputString($row['title']); ?></h3></nav>
<section id="mainContent">
<div class="content-container">


<table class="list">
	<tr>
		<th>Date</th>
		<th>User</th>
	</tr>
<?php
$qd = 'SELECT
	d.date_downloaded AS date_downloaded,
	u.username AS username,
	u.id AS userid
FROM
	'.PREFIX.'downloads AS d,
	'.PREFIX.'users AS u
WHERE
	d.article = "' . cleanString($_REQUEST['pageID']) . '" AND
	u.id = d.user
';
$rd = mysql_query($qd) or die(mysql_error());
$bg = 'dark';
while($download = mysql_fetch_assoc($rd)) : ?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo datetimeITA($download['date_downloaded']); ?></td>
		<td>
			<a href="../utenti.php?action=edit&ID=<?php echo $download['userid']; ?>" target="_blank">
				<?php echo outputString($download['username']); ?>
			</a>
		</td>
	</tr>
<?php
	if ($bg == 'dark') $bg = 'bright';
	else $bg = 'dark';
endwhile; ?>
</table>


</div>
</section>
<?php require('../sections/footer.php'); ?>

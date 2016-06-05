<?php
if (isset($_COOKIE['loginTry']) && $_COOKIE['loginTry'] > 3) :
?><div id="error">
		<?php echo $ERROR['too_many_connections']; ?>
</div><?php endif; ?>

<?php
if (isset($_REQUEST['error'])) :
	$errorArray = explode(',', $_REQUEST['error']);
?><div id="error">
<?php
for ($i=0; $i<count($errorArray); $i++) :
	echo "\t\t" . $ERROR[$errorArray[$i]] . "<br />\n";
endfor;
?>
</div><?php endif; ?>


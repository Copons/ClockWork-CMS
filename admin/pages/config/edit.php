<?php

if (checkIdInline($_REQUEST["ID"])) :

	$query = 'SELECT id FROM '.PREFIX.'config WHERE id = ' . $_REQUEST['ID'] . ' LIMIT 1';
	$result = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result) == 0) :
		default_message('The option does not exist.');
	else :

		require('pages/config/array.php');

		$query = 'SELECT * FROM '.PREFIX.'config WHERE id = ' . $_REQUEST['ID'];
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		editHeader		('config', 'option', $row['id'], $arrayOptions[$row['item']]);

		editInput		('value', $arrayOptions[$row['item']] . editHidden('item', $row['item']), $row['value'], '', '*', 'text', '70', '255');
		editSave		('config', $row['id'], $row['titolo']);

		editFooter		();

	endif;

endif;

?>

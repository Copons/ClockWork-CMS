<?php

require('../../include/process.inc.php');

checkLevel('admin', 'process');

if (checkIdInline($_REQUEST['ID'])) :

	$arrayFields = array('item'		=> 'clean',
						 'value'	=> 'clean');
	$fields = fieldsToArray($arrayFields);




	if ($fields['value']	== '') :

		setError('required_fields');
		redirect('../../news.php?action=edit&ID=' . $_REQUEST['ID']);

	else :

		require('array.php');

		$title = $fields['item'];
		unset($fields['item']);
		updateQuery('config', $fields, $_REQUEST['ID']);
		insertLogRecord('config', 'update', $_REQUEST['ID'], $arrayOptions[$title]);
		setOk('Option <strong>' . $arrayOptions[$title] . '</strong> updated.');
		redirect('../../config.php');

	endif;

endif;

?>

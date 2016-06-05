<?php

/*
$cms			[$key => $value]
$pageArray		[$slug => $title]
$config			[$key => $value]
*/




// CMS
//
// A simple array with keys and values for CMS data
$cms = array('name'			=> 'ClockWork CMS',
			 'version'		=> '2.5',
			 'year'			=> '2009-2016',
			 'copyright'	=> 'Jacopo Tomasone');




// PAGE ARRAY
//
// A simple array translating page slugs into page titles
// keys = page slugs
// values = page titles
$pageArray = array(
	'home'				=> 'Homepage',
	'login' 			=> 'Login',
	'pages'				=> 'Pages',
	'news'				=> 'News',
	'featured'			=> 'Featured',
	'users'				=> 'Users',
	'admin'				=> 'Administrators',
	'config'			=> 'Settings',
	'logs'				=> 'Logs'
);




// CONFIG
//
// An array with keys and values from the configuration table
$config = array();
$query = 'SELECT item, value FROM '.PREFIX.'config';
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_assoc($result))
	$config[$row['item']] = $row['value'];

?>

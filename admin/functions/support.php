<?php

/*
pageTitle		($page)
safePages		($page)
actionPage		($page)
mainMenu		($page, $minLevel)
menu			($page)
redirect		($path)
checkIdInline	($requestedId)
checkLevel		($level, $section)
empty_db		($message)
*/




// PAGE TITLE
//
// Prints the page title
// $page = requested page
function pageTitle ($page) {

	global $pageArray, $config;

	if (isset($page) && array_key_exists($page, $pageArray))
		echo $pageArray[$page] . ' | ';

	echo outputString($config['name']);

}




// SAFE PAGES
//
// Checks if the requested page is safe and then includes it
// $page = requested page
function safePages ($page) {

	global $pageArray, $config;

	if (isset($page) && array_key_exists($page, $pageArray))
		require('pages/' . $page . '/index.php');
	else
		require("pages/login/index.php");

}




// ACTION PAGES
//
// Includes the correct content for the requested action
// $page = requested page
function actionPage ($page) {

	if (!isset($_REQUEST['action']))
		require('pages/' . $page . '/view.php');
	else if ($_REQUEST['action'] == 'insert')
		require('pages/' . $page . '/insert.php');
	else if ($_REQUEST['action'] == 'single')
		require('pages/' . $page . '/single.php');
	else if ($_REQUEST['action'] == 'edit')
		require('pages/' . $page . '/edit.php');

}




// MAIN MENU
//
// Creates a main menu table item
// $page = page to which menu item refers
// $minLevel = a comma separated list of levels needed to access to this page; no level needed by default
function mainMenu ($page, $minLevel='', $current) {

	global $pageArray, $config;

	if (checkLevel($minLevel, 'item')) :
		?>
<li>
	<a href="<?php echo $page; ?>.php"<?php if ($page == $current) : ?> class="current-page"<?php endif; ?>>
		<span><?php echo $pageArray[$page]; ?></span>
		<img src="images/icons/<?php echo $page; ?>.png" />
	</a>
</li>
		<?php
	endif;

}




// MENU
//
// Creates the menu
// $page = page to which the menu refers
function menu ($page) {

	global $pageArray, $config;

	if ($page != 'home' &&
		$page != 'login') :
	?>
<nav id="menu" class="clear">
	<h3><img src="images/icons/<?php echo $page; ?>.png" /> <?php echo $pageArray[$page]; ?></h3>
	<?php

	if ($page != 'config' &&
		$page != 'logs') :
		?>
	<a href="<?php echo $page; ?>.php"><img src="images/view-all.png" alt="View All" /> View All</a>
	<a href="<?php echo $page; ?>.php?action=insert"><img src="images/insert-new.png" alt="Create New" /> Create New</a>
		<?php
	endif;

	echo '</nav>';
	endif;
}




// REDIRECT
//
// Prints an header redirection to the chosen path
// $path = path of redirection
function redirect ($path) {

	header('Location: ' . $path);
	exit();

}




// CHECK ID INLINE
//
// Checks if the requested id is numeric, or else redirects to page index
// Inline version (no redirect)
// $requestedId = requested id
function checkIdInline ($requestedId) {

	global $ERROR;

	if (!is_numeric($requestedId)) :
		default_message($ERROR['ID_value']);
		return FALSE;
	else :
		return TRUE;
	endif;

}




// CHECK LEVEL
//
// Checks if the user has the correct administration level to perform the requested action
// $level = a comma separated list of levels needed to perform the requested action
// $section = options: 'show', 'process' or 'item'. If 'item', does nothing, if 'show' prints an error message, else redirects to homepage
function checkLevel ($level, $section) {

	$levels = explode(',', $level);

	if ($level == '' || in_array($_COOKIE['level'], $levels))
		return TRUE;
	else
		if ($section == 'show') :
			default_message('You are not authorized.');
			return FALSE;
		elseif ($section == 'process') :
			setError('not_allowed');
			redirect('../../home.php');
		elseif ($section == 'item') :
			return FALSE;
		endif;
}




// DEFAULT MESSAGE
function default_message ($message) {
	echo '<div class="default-message">' . $message . '</div>';
}

?>

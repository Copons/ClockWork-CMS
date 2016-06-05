<?php

// Initialize config, DB and helpers

require_once('../admin/include/config.inc.php');
require_once('../helpers/utilities.php');
require_once('../helpers/db.php');
require_once('../helpers/str.php');
require_once('../helpers/config.php');
require_once('../helpers/html.php');
require_once('../helpers/page.php');


setcookie(PREFIX.'user', FALSE, time()-3600*5, '/');
unset($_COOKIE[PREFIX.'user']);

header('Location: ' . $c->ourl());
die();
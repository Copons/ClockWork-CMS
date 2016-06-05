<?php

// Initialize config, DB and helpers

require_once('admin/include/config.inc.php');
require_once('helpers/utilities.php');
require_once('helpers/db.php');
require_once('helpers/str.php');
require_once('helpers/config.php');
require_once('helpers/html.php');
require_once('helpers/page.php');




// Security

require_once('controllers/security.php');




// Routing

require_once('controllers/routes.php');




// Generating common contents

require_once('controllers/menu.php');
require_once('controllers/breadcrumbs.php');
require_once('controllers/pagination.php');




// Creating template

require_once('views/template/head.php');
require_once('views/template/header.php');
require_once('views/template/body.php');
require_once('views/template/news.php');
require_once('views/template/featured.php');
require_once('views/template/footer.php');

/*require_once('views/template/top-nav.php');
require_once('views/template/menu.php');
require_once('views/template/body.php');
require_once('views/template/aside.php');
require_once('views/template/secondary-body.php');
require_once('views/template/footer.php');*/

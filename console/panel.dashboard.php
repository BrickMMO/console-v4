<?php

security_check();
admin_check();

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'control');
define('PAGE_SELECTED_SUB_PAGE', '/panel/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>

<h2>Panel Dashboard</h2>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

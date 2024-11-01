<?php

security_check();
admin_check();

define('APP_NAME', 'Panels');

define('PAGE_TITLE', 'Modify values');
define('PAGE_SELECTED_SECTION', 'control');
define('PAGE_SELECTED_SUB_PAGE', '/admin/panel/values');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/control-panel.png"
        height="50"
        style="vertical-align: top" />
    Control Panel
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> /
    <a href="/admin/panel/dashboard">Control Panel</a> /
    Modify Values
</p>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

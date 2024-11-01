<?php

security_check();
admin_check();

if (isset($_GET['key']) && $_GET['key'] == 'go') 
{

    panels_new($_city['id']);

    message_set('Panel Success', 'A panel has been created for this city.');
    header_redirect('/panel/dashboard');

}

define('APP_NAME', 'Panels');

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

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/control-panel.png"
        height="50"
        style="vertical-align: top"
    />
    Control Panel
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/panel/dashboard">Control Panel</a> / 
    Initiate Panel
</p>
<hr />
<h2>Initiate Panel</h2>

<p>
    Initiate a control panel to integrate a digital or physical control panel into your smart city.
</p>    

<p>
    View existing panels at 
    <a href="https://panel.brickmmo.com">panel.brickmmo.com</a>
</p>
            
<a
    href="/panel/new/go"
    class="w3-button w3-white w3-border"
    onclick="loading();"
>
    <i class="fa-solid fa-download"></i> Initiate Panel
</a>
    
<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

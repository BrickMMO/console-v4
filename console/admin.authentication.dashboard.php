<?php

security_check();
admin_check();

define('APP_NAME', 'Auth');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/auth/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$github = setting_fetch('GITHUB_ACCESS_TOKEN');
$google = setting_fetch('GOOGLE_ACCESS_TOKEN');

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Authentication
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Authentication
</p>

<hr>

<h3>GitHub Authentication</h3>
<p>
    GitHub Access Token: <span class="w3-tag w3-blue">
        <?php if($github): ?>
            <?=$github?>
        <?php else: ?>
            not yet authenticated
        <?php endif; ?>
    </span> 
</p>

<a
    href="/admin/authentication/github"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Modify GitHub Authentication
</a>

<hr>



<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

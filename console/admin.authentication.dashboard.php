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

<h2>
    <i class="fa-brands fa-github"></i>
    GitHub
</h2>

<?php if($github): ?>

    <?php $github_user = github_user($github); ?>

    <p>
        <img src="<?=$github_user['avatar_url']?>" class="w3-circle w3-margin-right w3-left" width="70">
        <a href="<?=$github_user['html_url']?>">
            <?=$github_user['html_url']?>
        </a>
        <br>
        <?=$github_user['login']?>
        <br>
        <span class="w3-tag w3-blue">
            <?=github_display_token($github)?>
        </span>
    </p>

    <a 
        href="/action/github/app/revoke"
        class="w3-button w3-white w3-border"
    >
        <i class="fa-solid fa-key fa-padding-right"></i> Revoke GitHub Authentication
    </a>

<?php else: ?>

    <p>
        <span class="w3-tag w3-blue">
            NOT YET AUTHENTICATED
        </span> 
    </p>

    <a 
        href="<?=github_url('/action/github/app/token')?>"
        class="w3-button w3-white w3-border"
    >
        <i class="fa-solid fa-key fa-padding-right"></i> Authenticate GitHub
    </a>

<?php endif; ?>

<hr>

<h2> 
    <i class="fa-brands fa-google"></i>
    Google
</h2>

<?php if($google): ?>

    <p>
        <span class="w3-tag w3-blue">
            <?=google_display_token($google)?>
        </span>
    </p>

    <a 
        href="/action/google/app/revoke"
        class="w3-button w3-white w3-border"
    >
        <i class="fa-solid fa-key fa-padding-right"></i> Revoke Google Authentication
    </a>

<?php else: ?>

    <?php $google_auth_url = google_auth_url(); ?>

    <p>
        <span class="w3-tag w3-blue">
            NOT YET AUTHENTICATED
        </span> 
    </p>

    <a 
        href="<?=$google_auth_url?>"
        class="w3-button w3-white w3-border"
    >
        <i class="fa-solid fa-key fa-padding-right"></i> Authenticate Google
    </a>

<?php endif; ?>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

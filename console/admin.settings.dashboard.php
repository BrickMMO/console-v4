<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{


    foreach($_POST['setting'] as $key => $value)
    {
        // echo $key.' - '.$value.'<br>';
        setting_update($key, $value);
    }
    
    message_set('Settings Success', 'Your settings have been edited.');
    header_redirect('/admin/settings/dashboard');
    
}

define('APP_NAME', 'Settings');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/settings/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *
    FROM settings
    ORDER BY name ASC';
$settings = mysqli_query($connect, $query);

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Settngs
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Settings
</p>
<hr>

<h2>Update Settings</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <?php foreach($settings as $setting): ?>

        <div class="w3-margin-bottom">

        <input  
            name="setting[<?=$setting['name']?>]" 
            class="w3-input w3-border" 
            type="text" 
            id="setting" 
            autocomplete="off"
            value="<?=htmlentities($setting['value'])?>"
        />
        <label for="name" class="w3-text-gray">
            <?=$setting['name']?> <span id="name-error" class="w3-text-red"></span>
        </label>

        </div>

    <?php endforeach; ?>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-gear fa-padding-right"></i>
        Update Settings
    </button>
</form>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

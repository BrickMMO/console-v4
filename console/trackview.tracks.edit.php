<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']) || 
    !track_fetch($_GET['key']))
{
    message_set('Track Error', 'There was an error with the provided track.');
    header_redirect('/trackview/tracks');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {

        message_set('Track Error', 'There was an error with the provided track.', 'red');
        header_redirect('/admin/media/tags');
    }
    
    $query = 'UPDATE tracks SET
        name = "'.addslashes($_POST['name']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Track Success', 'Your track has been edited.');
    header_redirect('/trackview/tracks');
    
}

define('APP_NAME', 'Track View');

define('PAGE_TITLE','Edit Track');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/trackview/tracks');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$track = track_fetch($_GET['key']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/trackview.png"
        height="50"
        style="vertical-align: top"
    />
    Track View
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/trackview/dashboard">Track View</a> / 
    <a href="/trackview/tracks">Tracks</a> / 
    Edit Track
</p>

<hr />

<h2>Edit Track: <?=$track['name']?></h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="name" 
        class="w3-input w3-border" 
        type="text" 
        id="name" 
        autocomplete="off"
        value="<?=$track['name']?>"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Edit Track
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let name = document.getElementById("name");
        let name_error = document.getElementById("name-error");
        name_error.innerHTML = "";
        if (name.value == "") {
            name_error.innerHTML = "(name is required)";
            errors++;
        }

        if (errors) return false;
    }

</script>
    

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

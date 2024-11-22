<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']) || 
    !building_fetch($_GET['key']))
{
    message_set('Building Error', 'There was an error with the provided building.');
    header_redirect('/places/buildings');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {

        message_set('Building Error', 'There was an error with the provided building.', 'red');
        header_redirect('/admin/media/tags');
    }
    
    $query = 'UPDATE buildings SET
        `name` = "'.addslashes($_POST['name']).'",
        `set` = "'.addslashes($_POST['set']).'",
        `number` = "'.addslashes($_POST['number']).'",
        `colour` = "'.addslashes($_POST['colour']).'",
        `road_id` = "'.addslashes($_POST['road_id']).'",
        `updated_at` = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Building Success', 'Your building has been edited.');
    header_redirect('/places/buildings');
    
}

define('APP_NAME', 'Places');

define('PAGE_TITLE','Edit Building');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/places/buildings');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$building = building_fetch($_GET['key']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/places.png"
        height="50"
        style="vertical-align: top"
    />
    Places
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/places/dashboard">Places</a> / 
    <a href="/places/buildings">Buildings</a> / 
    Edit Building
</p>

<hr />

<h2>Edit Building: <?=$building['name']?></h2>

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
        value="<?=$building['name']?>"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <input  
        name="set" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="set" 
        autocomplete="off"
        value="<?=$building['set']?>"
    />
    <label for="set" class="w3-text-gray">
        LEGO Set Number <span id="set-error" class="w3-text-red"></span>
    </label>

    <input  
        name="colour" 
        class="w3-input w3-border" 
        type="text" 
        id="colour" 
        autocomplete="off"
        value="<?=$building['colour']?>"
    />
    <label for="colour" class="w3-text-gray">
        Colour <span id="colour-error" class="w3-text-red"></span>
    </label>

    <input  
        name="number" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="set" 
        autocomplete="off"
        value="<?=$building['number']?>"
    />
    <label for="number" class="w3-text-gray">
        Road Number <span id="number-error" class="w3-text-red"></span>
    </label>

    <?=form_select_table('road_id', 'roads', 'id', 'name', array('selected' => $building['road_id'], 'empty_key' => ''))?>
    <label for="road_id" class="w3-text-gray">
        Road <span id="road-id-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Edit Building
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

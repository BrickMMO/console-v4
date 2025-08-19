<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']))
    {
        message_set('Building Error', 'There was an error with the provided building.', 'red');
        header_redirect('/places/buildings/add');
    }
    
    $query = 'INSERT INTO buildings (
            `name`,
            `set`,
            `number`,
            `colour`,
            `road_id`,
            `city_id`,
            `created_at`,
            `updated_at`
        ) VALUES (
            "'.addslashes($_POST['name']).'",
            "'.addslashes($_POST['set']).'",
            "'.addslashes($_POST['number']).'",
            "'.addslashes($_POST['colour']).'",
            "'.addslashes($_POST['road_id']).'",
            "'.$_city['id'].'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    message_set('Tag Success', 'Your building has been added.');
    header_redirect('/places/buildings');
    
}

define('APP_NAME', 'Places');

define('PAGE_TITLE', 'Add Building');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/places/buildings');

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
    Add Building
</p>

<hr />

<h2>Add Building</h2>

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
    />
    <label for="set" class="w3-text-gray">
        LEGO Set Number <span id="set-error" class="w3-text-red"></span>
    </label>

    <input  
        name="colour" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="colour" 
        autocomplete="off"
    />
    <label for="colour" class="w3-text-gray">
        Colour <span id="colour-error" class="w3-text-red"></span>
    </label>

    <input  
        name="number" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="number" 
        autocomplete="off"
    />
    <label for="number" class="w3-text-gray">
        Road Number <span id="number-error" class="w3-text-red"></span>
    </label>

    <?=form_select_table('road_id', 'roads', 'id', 'name', array('empty_key' => ''))?>
    <label for="road_id" class="w3-text-gray">
        Road <span id="road-id-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Add Building
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
        let road = document.getElementById("road_id");
        let road_error = document.getElementById("road-id-error");
        road_error.innerHTML = "";
        if (road.value == "") {
            road_error.innerHTML = "(road is required)";
            errors++;
        }
        let number = document.getElementById("number");
        let number_error = document.getElementById("number-error");
        number_error.innerHTML = "";
        if (number.value == "") {
            number_error.innerHTML = "(number is required)";
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

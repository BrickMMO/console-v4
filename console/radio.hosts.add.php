<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    if (!validate_blank($_POST['name']) ||
    !validate_blank($_POST['prompt']) ||
    !validate_blank($_POST['voice'])
    )
    {
        message_set('Host Error', 'There was an error with the provided host.', 'red');
        header_redirect('/radio/hosts/add');
    }
    
    $query = 'INSERT INTO hosts (
            `name`,
            `voice`,
            `prompt`,
            `city_id`,
            `created_at`,
            `updated_at`
        ) VALUES (
            "'.addslashes($_POST['name']).'",
            "'.addslashes($_POST['voice']).'",
            "'.addslashes($_POST['prompt']).'",
            "'.$_city['id'].'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    message_set('Host Success', 'The host has been added.');
    header_redirect('/radio/hosts');
    
}

define('APP_NAME', 'Radio');
define('PAGE_TITLE', 'Host');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/radio/hosts');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');
include('../templates/message.php');


?>


<!-- CONTENT -->
<h1 class="w3-margin-top w3-margin-bottom">
 <!-- <img
       src=
    /> -->
    Radio
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/radio/dashboard">Radio</a> / 
    <a href="/radio/hosts">Hosts</a> / 
    Add Host
</p>

<hr />

<h2>Add Host</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="name" 
        class="w3-input w3-border w3-margin-top"
        type="text" 
        id="name" 
        autocomplete="off"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name_error" class="w3-text-red"></span>
    </label>


        
    <!-- Flora: added on 2025.1.20
    $voice = ["alloy" "ash", "coral", "echo", "fable", "onyx", "nova", "sage", "shimmer"]; -->

    <select 
        name="voice"
        class="w3-input w3-border w3-margin-top"
        id="voice" 
        autocomplete="off"
        >
        <option value="" disabled selected>Please select</option>
            <?php
            $values = array('alloy','ash','coral','nova', 'shimmer', 'echo', 'onyx', 'fable');
            foreach($values as $value){
                echo '<option value="' . $value . '">' . $value . '</option>';
            }

            ?>
        </select>
        <label for="voice" class="w3-text-gray">
        Voice<span id="voice_error" class="w3-text-red"></span>
    </label>

        
        <textarea  
            name="prompt" 
            class="w3-input w3-border w3-margin-top"
            id="prompt" 
            autocomplete="off"
        ></textarea>
        <label for="prompt" class="w3-text-gray">
            Prompt <span id="prompt_error" class="w3-text-red"></span>
        </label>




    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Add Host
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;;

        // name validation
        let name = document.getElementById("name");
        let name_error = document.getElementById("name_error");
        name_error.innerHTML = "";
        if (name.value == "") {
            name_error.innerHTML = "(name is required)";
            errors++;
        }


        // voice validation
        let voice = document.getElementById("voice");
        let voice_error = document.getElementById("voice_error");
        voice_error.innerHTML = "";
        if (voice.value == "" || voice.value == "Please select") {
            voice_error.innerHTML = "(voice is required)";
            errors++;
        }


        // prompt validation
        let prompt = document.getElementById("prompt");
        let prompt_error = document.getElementById("prompt_error");
        prompt_error.innerHTML = "";
        if (prompt.value == "") {
            prompt_error.innerHTML = "(Prompt is required to create a personalized radio voice.)";
            errors++;
        }

        if (errors) return false;
    }

</script>

<?php
require_once('../templates/modal_city.php');
require_once('../templates/main_footer.php');
require_once('../templates/debug.php');
require_once('../templates/html_footer.php');
?>

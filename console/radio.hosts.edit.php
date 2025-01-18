<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']) || 
    !host_fetch($_GET['key']))
{
    message_set('Host Error', 'There was annnn error with the provided host.', 'red');
    header_redirect('/radio/hosts');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['name']) ||
        !validate_blank($_POST['gender']) ||
        !validate_blank($_POST['prompt'])
    )
    {

        message_set('Host Error', 'There was an error with the provided host.', 'red');
        header_redirect('/radio/hosts');
    }

    $query = 'UPDATE hosts SET
        name = "'.addslashes($_POST['name']).'",
        gender = "'.addslashes($_POST['gender']).'",
        prompt = "'.addslashes($_POST['prompt']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Host Success', 'The host has been edited.');
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

$host = host_fetch($_GET['key']);

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
    Edit Host
</p>

<hr />

<h2>Edit Host: <?=$host['name']?></h2>

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
        value="<?=$host['name']?>"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-red"></span>
    </label>


    <select 
    name="gender"
    class="w3-input w3-border w3-margin-top"
    id="gender" 
    autocomplete="off"
    >
    <!-- <option value="" disabled selected>Please select</option> -->
        <?php
        $values = array('male','female');
        foreach($values as $value){
            echo '<option value="' . $value . '"';
            if (($host['gender']) === $value) {
                echo ' selected'; 
            }
            echo '>' . $value . '</option>';
        }

        ?>
    </select>
    <label for="gender" class="w3-text-gray">
    Gender<span id="gender-error" class="w3-text-red"></span>
    </label>

        
        <textarea  
            name="prompt" 
            class="w3-input w3-border w3-margin-top"
            id="prompt" 
            autocomplete="off"
        ><?= $host['prompt'] ?></textarea>
        <label for="prompt" class="w3-text-gray">
            Prompt <span id="prompt-error" class="w3-text-red"></span>
        </label>

        <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-tag fa-padding-right"></i>
        Edit Host
    </button>
        
<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

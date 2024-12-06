<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']) || 
    !application_fetch($_GET['key'])
) {
    message_set('Application Error', 'There was an error with the provided Application.');
    header_redirect('/admin/applications/dashboard');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Basic server-side validation
    if (!validate_blank($_POST['name'])) {
        message_set('Application Error', 'There was an error with the provided Application.', 'red');
        header_redirect('/admin/applications/edit/' . $_GET['key']);
    }

    $query = 'UPDATE applications SET
        name = "'.addslashes($_POST['name']).'",
        github = "'.addslashes($_POST['github']).'",
        url = "'.addslashes($_POST['url']).'",
        description = "'.addslashes($_POST['description']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].' 
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Application Success', 'Your application has been edited.');
    header_redirect('/admin/applications/dashboard');
}

define('APP_NAME', 'Setting');
define('PAGE_TITLE', 'Edit Application');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/applications/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$application = application_fetch($_GET['key']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Applications
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/admin/applications/dashboard">Applications</a> / 
    Edit Application
</p>

<hr />

<h2>Edit Application: <?=$application['name']?></h2>

<form method="post" novalidate id="main-form">

    <input  
        name="name" 
        class="w3-input w3-border" 
        type="text" 
        id="name" 
        autocomplete="off"
        value="<?=$application['name']?>"
    />
    <label for="name" class="w3-text-gray">
    Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <input  
        name="github" 
        class="w3-input w3-border" 
        type="text" 
        id="github" 
        autocomplete="off"
        value="<?=$application['github']?>"
    />
    <label for="github" class="w3-text-gray">
    GitHub <span id="github-error" class="w3-text-red"></span>
    </label>

    <input  
        name="url" 
        class="w3-input w3-border" 
        type="text" 
        id="url" 
        autocomplete="off"
        value="<?=$application['url']?>"
    />
    <label for="url" class="w3-text-gray">
    URL <span id="url-error" class="w3-text-red"></span>
    </label>

    <!-- Description Input -->
    <textarea  
        name="description" 
        class="w3-input w3-border" 
        id="description"
        rows="4"
    ><?=$application['description']?></textarea>
    <label for="description" class="w3-text-gray">
        Description <span id="description-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-application fa-padding-right"></i>
        Edit Application
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        // Validate Project Name
        let name = document.getElementById("name");
        let nameError = document.getElementById("name-error");
        nameError.innerHTML = "";
        if (name.value == "") {
            nameError.innerHTML = "(Application Name is required)";
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

?>

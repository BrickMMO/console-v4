<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Basic server-side validation
    if (!validate_blank($_POST['name'])) {
        message_set('Project Error', 'There was an error with the provided application.', 'red');
        header_redirect('/admin/applications/add');
    }

    $query = 'INSERT INTO applications (
            name,
            description,
            url,
            github,
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['name']).'",
            "'.addslashes($_POST['description']).'",
            "'.addslashes($_POST['url']).'",
            "'.addslashes($_POST['github']).'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    // Set success message and redirect
    message_set('Application Success', 'Your application has been added successfully.');
    header_redirect('/admin/applications/dashboard');
}

define('APP_NAME', 'Setting');
define('PAGE_TITLE', 'Add Application');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/applications/dashboard');

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
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Applications
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/admin/applications/dashboard">Applications</a> / 
    Add Application
</p>

<hr />

<h2>Add Application</h2>

<form method="post" novalidate id="main-form">
    
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
        name="github" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="github" 
        autocomplete="off"
    />
    <label for="github" class="w3-text-gray">
        GitHub <span id="github-error" class="w3-text-red"></span>
    </label>

    <input  
        name="url" 
        class="w3-input w3-border w3-margin-top" 
        type="text" 
        id="url" 
        autocomplete="off"
    />
    <label for="url" class="w3-text-gray">
        URL <span id="url-error" class="w3-text-red"></span>
    </label>

    <textarea  
        name="description" 
        class="w3-input w3-border w3-margin-top" 
        id="description"
        rows="4"
    ></textarea>
    <label for="description" class="w3-text-gray">
        Description <span id="description-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-diagram-project fa-diagram-project"></i>
        Add Application
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
            nameError.innerHTML = "(Name is required)";
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

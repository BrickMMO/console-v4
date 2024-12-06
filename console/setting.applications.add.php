<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Basic server-side validation
    if (!validate_blank($_POST['project_name'])) {
        message_set('Project Error', 'There was an error with the provided project.', 'red');
        header_redirect('/admin/applications/add');
    }

    // Insert project into the database
    $project_name = addslashes($_POST['project_name']);
    $description = addslashes($_POST['description']);
    
    $query = 'INSERT INTO projects (
                project_name,
                description,
                created_at,
                updated_at
              ) VALUES (
                "'. $project_name . '",
                "' . $description . '",
                NOW(),
                NOW()
              )';
    mysqli_query($connect, $query);

    // Set success message and redirect
    message_set('Project Success', 'Your project has been added successfully.');
    header_redirect('/admin/applications/dashboard');
}

define('APP_NAME', 'Setting');
define('PAGE_TITLE', 'Add Application');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/admin/applications/add');

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
    
    <!-- Project Name Input -->
    <input  
        name="project_name" 
        class="w3-input w3-border" 
        type="text" 
        id="project_name" 
        autocomplete="off"
    />
    <label for="project_name" class="w3-text-gray">
        Application Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <!-- Description Input -->
    <textarea  
        name="description" 
        class="w3-input w3-border" 
        id="description"
        rows="4"
    ></textarea>
    <label for="description" class="w3-text-gray">
        Description <span id="description-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-project fa-padding-right"></i>
        Add Application
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        // Validate Project Name
        let projectName = document.getElementById("project_name");
        let nameError = document.getElementById("name-error");
        nameError.innerHTML = "";
        if (projectName.value == "") {
            nameError.innerHTML = "(Project Name is required)";
            errors++;
        }

        // Validate Description
        let description = document.getElementById("description");
        let descriptionError = document.getElementById("description-error");
        descriptionError.innerHTML = "";
        if (description.value == "") {
            descriptionError.innerHTML = "(Description is required)";
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

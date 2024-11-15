<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    $user_id = $_user['id']; 

    $date = trim($_POST['date']);
    $hoursWorked = trim($_POST['hoursWorked']);
    $project = trim($_POST['project']);
    $task = trim($_POST['task']);
    $description = trim($_POST['description']);
    
    
    if (empty($date)) {
        message_set('Date Error', 'The date field cannot be empty.', 'red');
        header_redirect('/timesheets/dashboard/list');
        exit;
    }

    
    if (!is_numeric($hoursWorked) || $hoursWorked < 0) {
        message_set('Hours Worked Error', 'Please enter a valid number of hours worked.', 'red');
        header_redirect('/timesheets/dashboard/list');
        exit;
    }

   
    if (empty($project)) {
        message_set('Project Error', 'Project field cannot be empty.', 'red');
        header_redirect('/timesheets/dashboard/list');
        exit;
    }

    
    if (empty($task)) {
        message_set('Task Error', 'Task field cannot be empty.', 'red');
        header_redirect('/timesheets/dashboard/list');
        exit;
    }

    
    if (empty($description)) {
        message_set('Description Error', 'Description field cannot be empty.', 'red');
        header_redirect('/timesheets/dashboard/list');
        exit;
    }

    
    $date = mysqli_real_escape_string($connect, $date);
    $hoursWorked = mysqli_real_escape_string($connect, $hoursWorked);
    $project = mysqli_real_escape_string($connect, $project);
    $task = mysqli_real_escape_string($connect, $task);
    $description = mysqli_real_escape_string($connect, $description);

   
    $query = "INSERT INTO timesheets (user_id, date, hours_worked, project, task, description) 
              VALUES ('$user_id', '$date', '$hoursWorked', '$project', '$task', '$description')";
    mysqli_query($connect, $query);

    message_set('Timesheet added', 'Your timesheet has been added successfully.');
    header_redirect('/timesheets/dashboard/list');
}

define('APP_NAME', 'Timesheet');
define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/timesheets/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');
include('../templates/message.php');

?>



<main class="container my-5">
    <h1 class="w3-margin-top w3-margin-bottom">
        <img src="https://cdn.brickmmo.com/icons@1.0.0/timesheets.png" height="50" style="vertical-align: top" />
        Timesheet Dashboard
    </h1>
    <p>
        <a href="/city/dashboard">Workflow</a> / 
        Timesheets
    </p>
    <hr />

    
    <section class="time-sheet">
        <div class="containerInfo">
            <h2 class="mb-4">Log in hours</h2> 
            <form method="post" class="mb-4" novalidate id="main-form" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="date" class="form-label">Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required />
                    <span id="date_error" class="w3-text-red"></span>
                </div>

                <div class="mb-3">
                    <label for="hoursWorked" class="form-label">Hours Worked:</label>
                    <input type="number" id="hoursWorked" name="hoursWorked" class="form-control" min="0" required />
                    <span id="hoursWorked_error" class="w3-text-red"></span>
                </div>

                <div class="mb-3">
                    <label for="project" class="form-label">Project:</label>
                    <input type="text" id="project" name="project" class="form-control" required />
                    <span id="project_error" class="w3-text-red"></span>
                </div>

                <div class="mb-3">
                    <label for="task" class="form-label">Task:</label>
                    <input type="text" id="task" name="task" class="form-control" required />
                    <span id="task_error" class="w3-text-red"></span>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    <span id="description_error" class="w3-text-red"></span>
                </div>

                <button type="submit" class="w3-btn w3-white w3-border w3-border-red w3-text-red w3-round-large">Submit Timesheet</button>
            </form>
        </div>
    </section>

</main>


<script>
    function validateForm() {
        let errors = 0;

        let date = document.getElementById("date");
        let hoursWorked = document.getElementById("hoursWorked");
        let project = document.getElementById("project");
        let task = document.getElementById("task");
        let description = document.getElementById("description");

        let date_error = document.getElementById("date_error");
        let hoursWorked_error = document.getElementById("hoursWorked_error");
        let project_error = document.getElementById("project_error");
        let task_error = document.getElementById("task_error");
        let description_error = document.getElementById("description_error");

        date_error.innerHTML = "";
        hoursWorked_error.innerHTML = "";
        project_error.innerHTML = "";
        task_error.innerHTML = "";
        description_error.innerHTML = "";

        if (!date.value) {
            date_error.innerHTML = "(Date is required)";
            errors++;
        }

        if (hoursWorked.value < 0) {
            hoursWorked_error.innerHTML = "(Please enter a valid number of hours)";
            errors++;
        }

        if (!project.value) {
            project_error.innerHTML = "(Project name is required)";
            errors++;
        }

        if (!task.value) {
            task_error.innerHTML = "(Task name is required)";
            errors++;
        }

        if (!description.value) {
            description_error.innerHTML = "(Description is required)";
            errors++;
        }

        return errors === 0; 
    }
</script>

<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
?>

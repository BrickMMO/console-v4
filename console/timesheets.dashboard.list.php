<?php
security_check();
admin_check();

define('APP_NAME', 'Timesheets');
define('PAGE_TITLE', 'Timesheets List');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/timesheets/dashboard/list');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/timesheet_header.php');
include('../templates/message.php');


if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete']; 

   
    $query = "DELETE FROM timesheets WHERE id = $delete_id LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result) {
        message_set('Delete Success', 'Timesheet has been deleted.');
    } else {
        message_set('Delete Error', 'Error occurred while deleting the timesheet.');
    }

    
    header_redirect('/timesheets/dashboard/list');
    exit;
}

// Handle the update of a timesheet
if (isset($_POST['update'])) {
    $id = (int) $_POST['id']; 
    $date = $_POST['date'];
    $hours_worked = $_POST['hours_worked'];
    $project = $_POST['project'];
    $task = $_POST['task'];
    $description = $_POST['description'];

    // Validate inputs
    if (empty($date) || empty($hours_worked) || empty($project) || empty($task) || empty($description)) {
        message_set('Update Error', 'All fields are required.');
    } else {
        // Perform the update query
        $query = "UPDATE timesheets SET 
                    date = '$date', 
                    hours_worked = '$hours_worked', 
                    project = '$project', 
                    task = '$task', 
                    description = '$description' 
                  WHERE id = $id LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result) {
            message_set('Update Success', 'Timesheet has been updated.');
        } else {
            message_set('Update Error', 'Error occurred while updating the timesheet.');
        }
    }

    
    header_redirect('/timesheets/dashboard/list');
    exit;
}

?>


<div class="main-content">
    
    <h1 class="w3-margin-top w3-margin-bottom">
        <img src="https://cdn.brickmmo.com/icons@1.0.0/timesheets.png" height="50" style="vertical-align: top" />
        Timesheet 
    </h1>
    
    
    <p>
        <a href="/city/dashboard">Workflow</a> / 
        Timesheets
    </p>
    <h3>View Timesheet</h3>
    <hr />

    <?php
    
    function displayData() {
        global $connect;
        $query = "
            SELECT t.id, u.first AS user_name, t.date, t.hours_worked, t.project, t.task, t.description
            FROM timesheets t
            JOIN users u ON t.user_id = u.id
            ORDER BY t.date DESC
        "; 
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo '<table class="w3-table w3-bordered w3-striped w3-margin-bottom" style="border: 2px solid orange; border-collapse: collapse;">';
            echo '<thead>
                    <tr style="border: 2px solid orange;">
                        <th style="border: 1px solid gray;">Student</th>
                        <th style="border: 1px solid gray;">Date</th>
                        <th style="border: 1px solid gray;">Hours Worked</th>
                        <th style="border: 1px solid gray;">Project</th>
                        <th style="border: 1px solid gray;">Task</th>
                        <th style="border: 1px solid gray;">Description</th>
                        <th style="border: 1px solid gray;">Actions</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr id="timesheet-' . $row['id'] . '" style="border: 1px solid gray;">';
                echo '<td style="border: 1px solid gray;">' . $row['user_name'] . '</td>';
                echo '<td style="border: 1px solid gray;">' . $row['date'] . '</td>';
                echo '<td style="border: 1px solid gray;">' . $row['hours_worked'] . '</td>';
                echo '<td style="border: 1px solid gray;">' . $row['project'] . '</td>';
                echo '<td style="border: 1px solid gray;">' . $row['task'] . '</td>';
                echo '<td style="border: 1px solid gray;">' . $row['description'] . '</td>';
                echo '<td style="border: 1px solid gray;">
                        <a href="?edit=' . $row['id'] . '" class="w3-button w3-white w3-border">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <a href="?delete=' . $row['id'] . '" class="w3-button w3-white w3-border" onclick="return confirm(\'Are you sure you want to delete this timesheet?\')">
                            <i class="fa-solid fa-trash-can"></i> Delete
                        </a>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($connect) . '</div>';
        }
    }

   
    if (isset($_GET['edit'])) {
        $edit_id = (int) $_GET['edit']; 

        
        $query = "SELECT * FROM timesheets WHERE id = $edit_id LIMIT 1";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
           
            echo '<h2>Edit Timesheet</h2>';
            echo '<form method="POST" action="">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <label>Date:</label><br>
                    <input type="date" name="date" value="' . $row['date'] . '" required style="width: 100%; padding: 10px; font-size: 16px;"><br><br>
                    <label>Hours Worked:</label><br>
                    <input type="number" name="hours_worked" value="' . $row['hours_worked'] . '" required style="width: 100%; padding: 10px; font-size: 16px;"><br><br>
                    <label>Project:</label><br>
                    <input type="text" name="project" value="' . $row['project'] . '" required style="width: 100%; padding: 10px; font-size: 16px;"><br><br>
                    <label>Task:</label><br>
                    <input type="text" name="task" value="' . $row['task'] . '" required style="width: 100%; padding: 10px; font-size: 16px;"><br><br>
                    <label>Description:</label><br>
                    <textarea name="description" required style="width: 100%; padding: 10px; font-size: 16px; height: 150px;">' . $row['description'] . '</textarea><br><br>
                    <button type="submit" name="update" class="w3-button w3-white w3-border" style="padding: 10px 20px; font-size: 16px;">
                        <i class="fa-solid fa-save"></i> Save Changes
                    </button>
                  </form>';
        } else {
            echo '<div class="alert alert-danger">Timesheet not found.</div>';
        }
    } else {
        
        displayData();
    }
    ?>
</div> 

<?php
include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');
?>

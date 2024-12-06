<?php

security_check();
admin_check();

if (isset($_GET['delete'])) {
    $query = 'DELETE FROM projects 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);
    
    message_set('Delete Success', 'application has been deleted.');
    header_redirect('/admin/applications/dashboard');
}

define('APP_NAME', 'Setting');
define('PAGE_TITLE', 'Applications');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/admin/applications/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');
include('../templates/message.php');

// Query to fetch all projects and related details
$query = 'SELECT p.id AS project_id, 
        p.project_name, 
        (
            SELECT COUNT(DISTINCT ts.user_id) 
            FROM timesheets ts
            JOIN tasks t ON ts.task_id = t.id
            WHERE t.project_id = p.id 
            AND ts.date >= CURDATE() - INTERVAL 1 DAY
        ) AS active_users, 
        (
            SELECT SUM(ts.hours_worked) 
            FROM timesheets ts
            JOIN tasks t ON ts.task_id = t.id
            WHERE t.project_id = p.id
            AND ts.date >= CURDATE() - INTERVAL 1 DAY
        ) AS active_hours,
        (
            SELECT MAX(ts.date) 
            FROM timesheets ts
            WHERE ts.project_id = p.id
        ) AS last_update
    FROM 
        projects p
    ORDER BY p.project_name';

$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Application
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/applications/dashboard">Applications</a> 
</p>

<hr />

<h2>Applications</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th class="bm-table-number">Active Users</th>
        <th class="bm-table-number">Active Hours</th>
        <th class="bm-table-number">Last Updated</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['project_name']?>
            </td>
            <td>
                <?=$record['active_users']?>
            </td>
            <td>
                <?=$record['active_hours']?>
            </td>
            <td>
                <?=$record['last_update']?>
            </td>
            <td>
                <a href="/setting/applications/edit/<?=$record['project_id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the application <?=$record['project_name']?>?', '/admin/applications/dashboard/delete/<?=$record['project_id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/setting/applications/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-project fa-padding-right"></i> Add New Application
</a>

<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

?>

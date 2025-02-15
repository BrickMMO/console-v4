<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM schedules
        WHERE id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Schedule has been deleted.');
    header_redirect('/radio/schedule');
    
}

define('APP_NAME', 'Radio');
define('PAGE_TITLE', 'Schedule');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/radio/schedule');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');
include('../templates/message.php');

$query = 'SELECT schedules.*,
    schedule_types.name AS type_name,
    hosts.name AS host_name
    FROM schedules
    LEFT JOIN schedule_types
    ON schedules.type_id = schedule_types.id
    LEFT JOIN hosts
    ON schedules.host_id = hosts.id
    WHERE schedules.city_id = "'.$_city['id'].'"
    ORDER BY minute';
$result = mysqli_query($connect, $query);


?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img src="https://cdn.brickmmo.com/icons@1.0.0/radio.png" alt="Radio Broadcast Icon" height="50" style="vertical-align: top" /> 
    Radio
</h1>
<p><a href="/city/dashboard">Dashboard</a> / 
<a href="/radio/dashboard">Radio</a> / Schedule</p>
<hr>

<h2>Radio Schedule</h2>

<table class="w3-table w3-striped w3-bordered">
    <thead>
        <tr>
            <th>Minute</th>
            <th>Type</th>
            <th>Host</th>
            <th class="bm-table-icon"></th>
            <th class="bm-table-icon"></th>
        </tr>
    </thead>
    <tbody>
    <?php while($record = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($record['minute']) ?></td>
                <td><?= htmlspecialchars($record['type_name']) ?></td>
                <td><?= htmlspecialchars($record['host_name']) ?></td>
                <td>
                    <a href="/radio/schedule/edit/<?=$record['id']?>">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                </td>
                <td>
                    <a href="#" onclick="return confirmModal('Are you sure you want to delete the schedule?', '/radio/schedule/delete/<?=$record['id']?>');">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
    </tbody>
</table>

<hr>

<a href="/radio/schedule/add" class="w3-button w3-white w3-border">
    <i class="fa-solid fa-plus fa-padding-right"></i> Add Schedule
</a>

<?php
require_once('../templates/modal_city.php');
require_once('../templates/main_footer.php');
require_once('../templates/debug.php');
require_once('../templates/html_footer.php');
?>
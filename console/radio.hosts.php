<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM hosts 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'DELETE FROM schedules
        WHERE host_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Host has been deleted.');
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

$query = 'SELECT hosts.*, COUNT(schedules.id) AS schedule_count
FROM hosts
LEFT JOIN schedules ON hosts.id = schedules.host_id
GROUP BY hosts.id
ORDER BY hosts.id;';
$result = mysqli_query($connect, $query);

$hosts_count = mysqli_num_rows($result);

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
    Hosts
</p>

<hr />

<h2>Radio Hosts</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>Voice</th>
        <th>Prompt</th>
        <th>City</th>
        <th class="bm-table-number">Schedules</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>
                <?=$record['voice']?>
            </td>
            <td>
                <?=$record['prompt']?>
            </td>
            <td>
                <?=$record['city_id']?>
            </td>
            <td>
                <?=$record['schedule_count']?>
            </td>
            <td>
                <a href="/radio/hosts/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the host <?=$record['name']?>?', '/radio/hosts/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<hr>

<a
    href="/radio/hosts/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Host
</a>

<?php
require_once('../templates/modal_city.php');
require_once('../templates/main_footer.php');
require_once('../templates/debug.php');
require_once('../templates/html_footer.php');
?>

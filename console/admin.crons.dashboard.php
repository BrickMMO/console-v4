<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM crons 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Cron has been deleted.');
    header_redirect('/admin/crons/dashboard');
    
}

define('APP_NAME', 'Cron');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-settings');
define('PAGE_SELECTED_SUB_PAGE', '/admin/crons/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *
    FROM crons
    ORDER BY name';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/roadview.png"
        height="50"
        style="vertical-align: top"
    />
    Cron Jobs
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Cron Jobs
</p>

<hr />

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>URL</th>
        <th class="bm-table-number">When</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>
                <a href="<?=ENV_CONSOLE_DOMAIN?><?=$record['url']?>">
                    <?=$record['url']?>
                </a>
            </td>
            <td class="bm-table-number">
                <?=$record['when']?>
            </td>
            <td>
                <a href="/admin/crons/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the cron job <?=$record['name']?>?', '/admin/crons/dashboard/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/admin/crons/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Cron Job
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

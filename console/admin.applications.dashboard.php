<?php

security_check();
admin_check();

if (isset($_GET['delete'])) {
    $query = 'DELETE FROM applications 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);
    
    message_set('Delete Success', 'Application has been deleted.');
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

$query = 'SELECT *,(
        SELECT COUNT(DISTINCT user_id) 
        FROM timesheets
        WHERE application_id = applications.id
    ) AS users,(
        SELECT IFNULL(SUM(hours),0)
        FROM timesheets
        WHERE application_id = applications.id
    ) AS hours,(
        SELECT MAX(date) 
        FROM timesheets
        WHERE application_id = applications.id
    ) AS last_update
    FROM applications
    ORDER BY name';
$result = mysqli_query($connect, $query);

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
    Applications
</p>

<hr />

<h2>Applications</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-image"></th>
        <th>Name</th>
        <th class="bm-table-number">Users</th>
        <th class="bm-table-number">Hours</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td class="bm-table-image">
                <?php if($record['image']): ?>
                    <img src="<?=$record['image']?>" width="100">
                <?php endif; ?>
            </td>
            <td>
                <?=$record['name']?>
                <small>
                    <?php if($record['url']): ?>
                        <br>
                        <a href="<?=$record['url']?>"><?=$record['url']?></a>
                    <?php endif; ?>
                    <?php if($record['github']): ?>
                        <br>
                        <a href="https://github.com/BrickMMO/<?=$record['github']?>">https://github.com/BrickMMO/<?=$record['github']?></a>
                    <?php endif; ?>
                </small>
            </td>
            <td class="bm-table-number">
                <?=$record['users']?>
            </td>
            <td class="bm-table-number">
                <?=$record['hours']?>
            </td>
            <td>
                <a href="/admin/applications/image/<?=$record['id']?>">
                    <i class="fa-solid fa-image"></i>
                </a>
            </td>
            <td>
                <a href="/admin/applications/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the application <?=$record['name']?>?', '/admin/applications/dashboard/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/admin/applications/add"
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

<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM tags 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'DELETE FROM tags
        WHERE medium_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'project has been deleted.');
    header_redirect('/setting/projects');
    
}

define('APP_NAME', 'Setting');

define('PAGE_TITLE', 'projects');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/setting/projects');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT tags.*,(
        SELECT COUNT(id)
        FROM media
        LEFT JOIN media_tag
        ON media.id = media_tag.medium_id
        WHERE image IS NOT NULL
    ) AS images,(
        SELECT COUNT(id)
        FROM media
        LEFT JOIN media_tag
        ON media.id = media_tag.medium_id
        WHERE video IS NOT NULL
    ) AS videos
    FROM tags
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
    Projects
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/projects/dashboard">Projects</a> 
</p>

<hr />

<h2>Projects</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th class="bm-table-number">Active Users</th>
        <th class="bm-table-number">Active Hours</th>
        <th class="bm-table-number">last Updated</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td class="bm-table-number">
                <?=$record['images']?>
            </td>
            <td class="bm-table-number">
                <?=$record['videos']?>
            </td>
            <td class="bm-table-number">
                <?=$record['videos']?>
            </td>
            <td>
                <a href="/setting/projects/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the project <?=$record['name']?>?', '/setting/projects/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/setting/projects/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-project fa-padding-right"></i> Add New project
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

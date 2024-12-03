<?php

security_check();
admin_check();

if (isset($_GET['approve'])) 
{

    $query = 'UPDATE media SET
        approved = 1
        WHERE id = '.$_GET['approve'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Approval Success', 'Video has been deleted.');
    header_redirect('/admin/media/video');
    
}


define('APP_NAME', 'Media');

define('PAGE_TITLE', 'Vdeo');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/admin/media/video');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT media.*,
    (
        SELECT COUNT(*)
        FROM media_downloads
        WHERE media_downloads.media_id = media.id
    ) AS downloads
    FROM media
    LEFT JOIN cities 
    ON city_id = cities.id
    LEFT JOIN users 
    ON media.user_id = users.id
    WHERE type = "video"
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
    Media
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/admin/media/dashboard">Media</a> / 
    Video
</p>

<hr />

<h2>Video</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>Tags</th>
        <th class="bm-table-number"><i class="fa-solid fa-download"></i></th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>
                <?php foreach(media_tags($record['id']) as $tag):?>
                    <span class="w3-tag w3-blue"><?=$tag['name']?></span>
                <?php endforeach; ?>
            </td>
            <td class="bm-table-number">
                <?=$record['downloads']?>
            </td>
            <td class="bm-table-icon">
                <?php if($record['approved'] == 1): ?>
                    <i class="fa-solid fa-thumbs-up w3-text-green"></i>
                <?php else: ?>
                    <a href="#" onclick="return confirmModal('Are you sure you want to approve the video <?=$record['name']?>?', '/admin/media/video/approve/<?=$record['id']?>');">
                        <i class="fa-solid fa-thumbs-down w3-text-red"></i>
                    </a>
                <?php endif; ?>
            </td>
            <td class="bm-table-icon">
                <a href="/admin/media/video/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
  href="/action/google/import/video"
  class="w3-button w3-white w3-border" 
  onclick="loading();"
>
  <i class="fa-solid fa-file-import fa-padding-right"></i> Import Video from Google Drive
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

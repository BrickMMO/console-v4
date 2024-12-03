<?php

security_check();
admin_check();

define('APP_NAME', 'Media');

define('PAGE_TITLE', 'Tags');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/admin/media/images');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT media.*
    FROM media
    LEFT JOIN cities 
    ON city_id = cities.id
    LEFT JOIN users 
    ON media.user_id = users.id
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
    Images
</p>

<hr />

<h2>Images</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>Tags</th>
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
            <td>
                <?php if($record['approved'] == 1): ?>
                    <i class="fa-solid fa-thumbs-up w3-text-green"></i>
                <?php else: ?>
                    <i class="fa-solid fa-thumbs-down w3-text-red"></i>
                <?php endif; ?>
            </td>
            <td>
                <a href="/admin/media/images/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
  href="/action/google/import/image"
  class="w3-button w3-white w3-border" 
  onclick="loading();"
>
  <i class="fa-solid fa-file-import fa-padding-right"></i> Import Images from Google Drive
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM tracks 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'UPDATE squares SET
        track_id = 0
        WHERE track_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Track has been deleted.');
    header_redirect('/trackview/tracks');
    
}

define('APP_NAME', 'Trackvie');

define('PAGE_TITLE', 'Tracks');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/trackview/tracks');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *,(
        SELECT COUNT(*)
        FROM squares
        WHERE track_id = tracks.id
    ) AS squares,(
        SELECT COUNT(*)
        FROM square_images
        INNER JOIN squares
        ON square_id = squares.id
        WHERE track_id = tracks.id
    ) AS images
    FROM tracks
    ORDER BY name';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/trackview.png"
        height="50"
        style="vertical-align: top"
    />
    Track View
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/trackview/dashboard">Track View</a> / 
    Tracks
</p>

<hr />

<h2>Tracks</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th class="bm-table-number">Squares</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>                
                <?=$record['images']?>/<?=$record['squares'] * 4?>
            </td>
            <td>
                <a href="/trackview/tracks/squares/<?=$record['id']?>">
                    <?=$record['squares']?>
                </a>
            </td>
            <td>
                <a href="/trackview/tracks/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the track <?=$record['name']?>?', '/trackview/tracks/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/trackview/tracks/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Track
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

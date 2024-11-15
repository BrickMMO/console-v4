<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM roads 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'UPDATE squares SET
        road_id = 0
        WHERE road_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Road has been deleted.');
    header_redirect('/roadview/roads');
    
}

define('APP_NAME', 'Roadvie');

define('PAGE_TITLE', 'Roads');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/roadview/roads');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT *,(
        SELECT COUNT(*)
        FROM squares
        WHERE road_id = roads.id
    ) AS squares,(
        SELECT COUNT(*)
        FROM square_images
        INNER JOIN squares
        ON square_id = squares.id
        WHERE road_id = roads.id
    ) AS images
    FROM roads
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
    Road View
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/roadview/dashboard">Road View</a> / 
    Roads
</p>

<hr />

<h2>Roads</h2>

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
                <a href="/roadview/roads/squares/<?=$record['id']?>">
                    <?=$record['squares']?>
                </a>
            </td>
            <td>
                <a href="/roadview/roads/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the road <?=$record['name']?>?', '/roadview/roads/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/roadview/roads/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Road
</a>

<?php

include('../templates/modal_city.php');

include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

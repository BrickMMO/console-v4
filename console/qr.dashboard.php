<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM qrs 
        WHERE id = '.$_GET['delete'].'
        AND city_id = '.$_city['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'DELETE FROM qr_logs
        WHERE qr_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'QR code has been deleted.');
    header_redirect('/qr/dashboard');
    
}

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/qr/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

$query = 'SELECT qrs.*,(
        SELECT COUNT(*)
        FROM qr_logs
        WHERE qrs.id = qr_logs.qr_id
    ) AS scans
    FROM qrs 
    WHERE city_id = '.$_city['id'].'
    ORDER BY name';
$result = mysqli_query($connect, $query);
$qr_count = mysqli_num_rows($result);

$query = 'SELECT *
    FROM qr_logs
    INNER JOIN qrs 
    ON qrs.id = qr_logs.qr_id
    AND city_id = '.$_city['id'].'';
$log_count = mysqli_num_rows(mysqli_query($connect, $query));

?>

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/events.png"
        height="50"
        style="vertical-align: top"
    />
    QR Codes
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    QR Codes
</p>
<hr>
<p>
    Total QR Codes: <span class="w3-tag w3-blue"><?=$qr_count?></span> 
    Total Scans: <span class="w3-tag w3-blue"><?=$log_count?></span> 
</p>

<hr>


<h3>QR Codes</h3>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-icon"></th>
        <th>Name</th>
        <th class="bm-table-number">Scans</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <img src="<?=$record['image'] ?>" alt="QR Code" width="70">
            </td>
            <td>
                <?=$record['name'] ?>
                <small>
                    <br>
                    Scan URL: <a href="<?=$record['url'] ?>"><?=$record['url'] ?></a>
                    <br>
                    Redirect URL: <a href="https://qr.brickmmo.com/<?=$record['hash'] ?>">https://qr.brickmmo.com/<?=$record['hash'] ?></a>
                </small>
            </td>
            <td>
                <a href="/qr/logs/<?=$record['id']?>"><?=$record['scans']?></a>
            </td>
            <td>
                <a href="/qr/edit/<?=$record['id'] ?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the QR code <?=$record['name'] ?>?', '/qr/dashboard/delete/<?=$record['id'] ?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/qr/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Add New QR Code
</a>

<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

?>

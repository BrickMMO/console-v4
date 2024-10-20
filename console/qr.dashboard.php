<?php

security_check();
admin_check();

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/qr/dashboard');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/  message.php');

$query = 'SELECT * FROM qr_codes ORDER BY id DESC';
$result = mysqli_query($connect, $query);

?>

<h2>QR Dashboard</h2>

<a href="/qr/add" class="w3-margin-top w3-margin-bottom">Add New QR Code</a>
<a href="/qr/scanlog" class="w3-margin-top w3-margin-bottom">View QR Scan Logs</a>

<hr />

<h3>QR Codes</h3>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th>QR Code</th>
        <th>Redirect URL</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $record['name'] ?></td>
            <td><img src="<?= $record['qr_code_image'] ?>" alt="QR Code" width="100"></td>
            <td><a href="<?= $record['redirect_url'] ?>" target="_blank"><?= $record['redirect_url'] ?></a></td>
            <td>
                <a href="/qr/edit/id/<?= $record['id'] ?>" class="w3-button">Edit</a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the QR code <?= $record['name'] ?>?', '/qr/delete/id/<?= $record['id'] ?>');" class="w3-button">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<?php

include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

?>

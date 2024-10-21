<?php

security_check();
admin_check();

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'QR Scan Logs');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/qr/scan-log');


include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');
include('../templates/message.php');


$query = 'SELECT qr_code_logs.*, qr_codes.name AS qr_name 
          FROM qr_code_logs 
          JOIN qr_codes ON qr_code_logs.qr_code_id = qr_codes.id 
          ORDER BY scan_date DESC';

$result = mysqli_query($connect, $query);


if (!$result) {
    die('Database query failed: ' . mysqli_error($connect));
}

?>

<h2>QR Scan Logs</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>QR Code Name</th>
        <th>Scanned Name</th>
        <th>Scanned URL</th>
        <th>Scan Time</th>
    </tr>

    <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($record['qr_name']) ?></td>
            <td><?= htmlspecialchars($record['scanned_name']) ?></td>
            <td><a href="<?= htmlspecialchars($record['scanned_url']) ?>" target="_blank"><?= htmlspecialchars($record['scanned_url']) ?></a></td>
            <td><?= htmlspecialchars($record['scan_date']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php

// Include footer templates
include('../templates/modal_city.php');
include('../templates/main_footer.php');
include('../templates/debug.php');
include('../templates/html_footer.php');

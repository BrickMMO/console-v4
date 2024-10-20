<?php

security_check();
admin_check();

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'Add QR Code');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/qr/add');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $redirect_url = mysqli_real_escape_string($connect, $_POST['redirect_url']);
    $unique_id = uniqid();

    $qrCode = new QrCode('https://qr.brickmmo.com/#/' . $unique_id);
    $writer = new PngWriter();
    $dataUri = $writer->write($qrCode)->getDataUri();

    // Save QR code details to the database
    $query = 'INSERT INTO qr_codes (name, redirect_url, qr_code_image, unique_id) 
              VALUES ("' . $name . '", "' . $redirect_url . '", "' . $dataUri . '", "' . $unique_id . '")';
    mysqli_query($connect, $query);

    message_set('QR Code Created', 'QR Code has been successfully created.');
    
    header_redirect('/qr/dashboard');
    exit();
}

?>

<h2>Add New QR Code</h2>

<form action="" method="POST" class="w3-container w3-card-4 w3-light-grey w3-padding">
    <div class="w3-section">
        <label for="name">QR Code Name:</label>
        <input class="w3-input w3-border" type="text" name="name" required>
    </div>
    <div class="w3-section">
        <label for="redirect_url">Redirect URL:</label>
        <input class="w3-input w3-border" type="url" name="redirect_url" required>
    </div>
    <button type="submit" class="w3-button w3-blue w3-margin-top">Generate QR Code</button>
</form>

<?php

include('../templates/main_footer.php');
include('../templates/html_footer.php');

?>
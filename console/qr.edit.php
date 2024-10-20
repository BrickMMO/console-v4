<?php

security_check();
admin_check();

define('APP_NAME', 'Events');
define('PAGE_TITLE', 'Edit QR Code');
define('PAGE_SELECTED_SECTION', 'community');
define('PAGE_SELECTED_SUB_PAGE', '/qr/edit');

include('../templates/html_header.php');
include('../templates/nav_header.php');
include('../templates/nav_slideout.php');
include('../templates/nav_sidebar.php');
include('../templates/main_header.php');

include('../templates/message.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM qr_codes WHERE id = '$id'";
    $result = mysqli_query($connect, $query);
    $qrCode = mysqli_fetch_assoc($result);

    if (!$qrCode) {
        message_set('Error', 'QR code not found.');
        header_redirect('qr.dashboard');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $redirect_url = mysqli_real_escape_string($connect, $_POST['redirect_url']);

    $query = "UPDATE qr_codes 
              SET name = '$name', redirect_url = '$redirect_url' 
              WHERE id = '$id'";
    mysqli_query($connect, $query);

    message_set('QR Code Updated', 'QR Code has been successfully updated.');
    header_redirect('/qr/dashboard');
    exit();
}

?>
<h2>Edit QR Code</h2>

<!-- Display the QR code -->
<div class="w3-center w3-padding">
    <h3>QR Code Preview</h3>
    <img src="<?= $qrCode['qr_code_image'] ?>" alt="QR Code" class="w3-image" style="width: 300px; height: 300px;">
</div>

<!-- Edit form -->
<form action="" method="POST" class="w3-container w3-card-4 w3-light-grey w3-padding">
    <div class="w3-section">
        <label for="name">QR Code Name:</label>
        <input class="w3-input w3-border" type="text" name="name" value="<?= htmlspecialchars($qrCode['name']) ?>" required>
    </div>
    <div class="w3-section">
        <label for="redirect_url">Redirect URL:</label>
        <input class="w3-input w3-border" type="url" name="redirect_url" value="<?= htmlspecialchars($qrCode['redirect_url']) ?>" required>
    </div>
    <button type="submit" class="w3-button w3-blue w3-margin-top">Update QR Code</button>
</form>

<?php

include('../templates/main_footer.php');
include('../templates/html_footer.php');

?>

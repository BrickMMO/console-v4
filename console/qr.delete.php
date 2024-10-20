<?php

security_check();
admin_check();

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);


    $query = "DELETE FROM qr_codes WHERE id = '$id' LIMIT 1";
    mysqli_query($connect, $query);

    message_set('Delete Success', 'QR Code has been deleted.');
}


header('Location: /qr/dashboard');
exit();

<?php

$data = array(
    'message' => '',
    'error' => false,
    'redirect_url' => null,
);

$requestUri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', trim($requestUri, '/'));

// Check if the request matches the expected format
if (isset($uriParts[3]) && $uriParts[2] === 'redirect' && isset($uriParts[4])) {
    $id = mysqli_real_escape_string($connect, $uriParts[4]);

    $query = "SELECT id, redirect_url, name FROM qr_codes WHERE unique_id = '$id'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Set the redirect URL in the response
        $data['redirect_url'] = $row['redirect_url'];
        $data['message'] = 'Redirect URL retrieved successfully.';

        // Log the scan details
        $qrCodeId = $row['id'];
        $scannedUrl = $row['redirect_url']; 
        $scannedName = $row['name']; 
        $scanDate = date('Y-m-d H:i:s');

        // Insert the log entry into the 'qr_code_logs' table
        $logQuery = "INSERT INTO qr_code_logs (qr_code_id, scanned_url, scanned_name, scan_date)
                     VALUES ('$qrCodeId', '$scannedUrl', '$scannedName', '$scanDate')";

        $logResult = mysqli_query($connect, $logQuery);

        if (!$logResult) {
            error_log("Error logging the QR code scan: " . mysqli_error($connect));
        }

    } else {
        $data['message'] = 'QR code not found.';
        $data['error'] = true;
    }
} else {
    $data['message'] = 'Invalid request format.';
    $data['error'] = true;
}

header("Content-Type: application/json");
echo json_encode($data, JSON_PRETTY_PRINT);
exit;

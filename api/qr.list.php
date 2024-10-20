<?php

$query = 'SELECT id, name, qr_code_image, redirect_url FROM qr_codes';
$result = mysqli_query($connect, $query);

// Clear the output buffer
ob_start();

$data = [];

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $data = array(
            'message' => 'QR codes retrieved successfully.',
            'error' => false,
            'qr_codes' => array(),
        );

        while ($row = mysqli_fetch_assoc($result)) {
            $qr_code = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'image_url' => $row['qr_code_image'],  
                'redirect_url' => $row['redirect_url'],
            );

           
            $data['qr_codes'][] = $qr_code;
        }
    } else {
        $data = array(
            'message' => 'No QR codes found.',
            'error' => false,
            'qr_codes' => array(), 
        );
    }
} else {
    $data = array(
        'message' => 'Error retrieving QR codes.',
        'error' => true,
        'qr_codes' => null,
    );
}

header("Content-Type: application/json");
echo json_encode($data);

// Clear the output buffer and end the script
ob_end_flush();
exit();

?>

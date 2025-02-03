<?php

$length = 1;
$filename = basename(__FILE__);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);


$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: qr code.
';

$query='SELECT qrs.*, COUNT(qr_logs.qr_id) AS qr_count
    FROM qrs
    LEFT JOIN qr_logs ON qr_logs.qr_id=qrs.id
    GROUP BY qrs.id';

    $result = mysqli_query($connect, $query);    


while ($qrCount = mysqli_fetch_assoc($result)) {    
    $parsedUrl = parse_url($qrCount['url'], PHP_URL_HOST);
    $prompt .='There have been ' . $qrCount['qr_count'] . ' clicks on the QR code for ' .   $parsedUrl;
}

;


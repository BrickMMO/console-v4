<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: brixsum.
';

// get SMART city
$query='SELECT `value`
    FROM settings
    WHERE name = "BRICKSUM_WORDLIST"';

$result = mysqli_query($connect, $query);
$bricksum = mysqli_fetch_assoc($result);


$prompt .='It includes a variety of exciting features:' . $bricksum['value'] . '.
';
<?php

// $length = 1;
$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: city.';

// get SMART city
$query='SELECT `name`
    FROM cities
    WHERE id = 1';

$result = mysqli_query($connect, $query);

while ($city = mysqli_fetch_assoc($result)) {
    $prompt .= 'Generate a description for ' . $city['name'] . ' using the information provided below.';
}

$prompt .= 'The city has radio stations, traffic announcements, news and other events. You can explore more by scanning QR codes!'; 
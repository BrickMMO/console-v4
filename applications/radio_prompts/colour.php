<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: color.';

// get colour
$query='SELECT `name`
    FROM colours
    ORDER BY RAND()
    LIMIT 1';

    $result = mysqli_query($connect, $query);

    while ($colour = mysqli_fetch_assoc($result)) {
        $prompt .= 'Create a day description based on ' . $colour['name'] . '. ';
    }

$prompt .= 'Each color is used to describe the day in a natural way, focusing on the feeling the color evokes. No color codes'; 
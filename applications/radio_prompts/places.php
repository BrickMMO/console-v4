<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. '; 

// HOST information $_city
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. 

The topic of this segment is places. 

Here is a list of each place, and location.

';


// http://local.console.brickmmo.com:7777/places/buildings

$query='SELECT buildings.*, roads.name AS road_name
    FROM buildings
    LEFT JOIN roads ON roads.id=buildings.road_id';

    $result = mysqli_query($connect, $query);    
    $buildingNum = mysqli_num_rows($result);

    while ($buildings = mysqli_fetch_assoc($result)) {  
        // need to update if second city has buildings
        $prompt .='There are ' . $buildingNum . 'places in the smart city';
        $prompt .= $buildings['name'].' is at '. $buildings['road_name'].' in .'. $buildings['colour'];
    }

$prompt .= 'Give a brief description based on the information from places. 

Include at least 3 places. 

';  
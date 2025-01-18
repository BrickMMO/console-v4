<?php

$length = 1;
$filename = basename(__FILE__);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 

There is one host for the radio station.'; 

$query='SELECT schedules.*,
    schedule_types.filename AS type_filename,
    hosts.name AS host_name,
    hosts.gender AS host_gender,
    hosts.prompt AS host_prompt
    FROM schedules
    LEFT JOIN schedule_types
    ON schedules.type_id = schedule_types.id
    LEFT JOIN hosts
    ON schedules.host_id = hosts.id
    WHERE schedules.city_id = "'.$_GET['key'].'"
    AND schedule_types.filename = "' . $filename . '"
    LIMIT 1';

$result = mysqli_query($connect, $query);


while($hosts = mysqli_fetch_assoc($result))
{
    $prompt .= ' The host is ' . $hosts['host_name'] . ', who has the following personal traits: ' . $hosts['host_prompt'] . '. The host is a ' . $hosts['host_gender'] . '.';
}

$prompt .=' Only include the words the host will say, no instructions, no host names, no music or sounds. Please generate a personalized audio based on the gender and personal traits when creating mp3. Adjust the tone, speed, timbre, and speaking habits to make the voice exaggerated and distinctive.

The topic of this segment is color. 
';

$query='SELECT `name`,`rgb`
    FROM colours
    ORDER BY RAND()
    LIMIT 1';

    $result = mysqli_query($connect, $query);

    while ($colour = mysqli_fetch_assoc($result)) {
        $prompt .= 'Create a day description based on ' . $colour['name'] . ' and ' . $colour['rgb'] . '. ';
    }

$prompt .= 'Each color is used to describe the day in a natural way, focusing on the feeling the color evokes. No color codes'; 
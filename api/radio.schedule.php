<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}


$query = 'SELECT schedules.*,
    schedule_types.name AS type_name,
    hosts.name AS host_name
    FROM schedules
    LEFT JOIN schedule_types
    ON schedules.type_id = schedule_types.id
    LEFT JOIN hosts
    ON schedules.host_id =hosts.id
    WHERE schedules.city_id = "'.$_GET['key'].'"
    ORDER BY minute';
$result = mysqli_query($connect, $query);

$data = array();

while($schedule = mysqli_fetch_assoc($result))
{
    $data[] = $schedule;
}

$data = array(
    'message' => 'Schedule has been loaded.',
    'error' => false, 
    'schedule' => $data,
);


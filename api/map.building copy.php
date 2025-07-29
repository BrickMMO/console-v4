<?php

/*
 *
 * API endpoint to retrieve the details for a specified building
 * URL: https://api.brickmmo.com/map/building/city_id/{city_id}/building_id/{building_id}
 * 
 */

// Check for required parameters
if(!isset($_GET['city_id']) || !is_numeric($_GET['city_id']))
{
    $data = array('message' => 'No city ID specified.', 'error' => true);
    return;
}
elseif(!isset($_GET['building_id']) || !is_numeric($_GET['building_id']))
{
    $data = array('message' => 'No building ID specified.', 'error' => true);
    return;
}

$city_id = $_GET['city_id'];
$building_id = $_GET['building_id'];

$query = 'SELECT * 
    FROM buildings 
    WHERE id = "'.$building_id.'" 
    AND city_id = "'.$city_id.'" 
    LIMIT 1';
$result = mysqli_query($connect, $query);

if(!mysqli_num_rows($result)) 
{
    $data = array('message' => 'No building found.', 'error' => true);
    return;
}

$building = mysqli_fetch_assoc($result);

$data = [
    'message' => 'Buildings retrieved successfully.',
    'error' => false,
    'buildings' => $building,
];

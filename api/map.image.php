<?php

/*
 *
 * API endpoint to retrieve the images for a square and direction.
 * URL: https://api.brickmmo.com/map/image/city_id/{city_id}/square_id/{square_id}/direction/{direction}
 * 
 */

// Check for required parameters
if(!isset($_GET['city_id']) || !is_numeric($_GET['city_id']))
{
    $data = array('message' => 'No city ID specified.', 'error' => true);
    return;
}
elseif(!isset($_GET['square_id']) || !is_numeric($_GET['square_id']))
{
    $data = array('message' => 'No square ID specified.', 'error' => true);
    return;
}
elseif(!isset($_GET['direction']) || !in_array($_GET['direction'], array('north', 'south', 'east', 'west')))
{
    $data = array('message' => 'No direction specified.', 'error' => true);
    return;
}

// Place URL parameters into variables
$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;
$square_id = isset($_GET['square_id']) ? intval($_GET['square_id']) : null;
$direction = isset($_GET['direction']) ? $_GET['direction'] : null;

$query = "SELECT image 
    FROM square_images 
    WHERE square_id = $square_id  
    AND direction = '$direction'
    LIMIT 1";
$result = mysqli_query($connect, $query);

if(!mysqli_num_rows($result)) 
{
    $data = array('message' => 'No square found specified.', 'error' => true);
    return;
}

$square = mysqli_fetch_assoc($result);

$data = array(
    'message' => 'Square image retrieved successfully.',
    'error' => false, 
    'squares' => $square,
);

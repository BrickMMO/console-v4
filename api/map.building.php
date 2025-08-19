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

<<<<<<< HEAD
if ($result) {
    while ($building = mysqli_fetch_assoc($result)) {
        $buildingArray[] = [
            'id' => $building['id'],
            'name' => $building['name'],
            'set' => $building['set'],
            'colour' => $building['colour'],
            'square_id' => $building['square_id']
        ];
    }

    $data = [
        'message' => 'Buildings retrieved by id successfully.',
        'error' => false,
        'buildings' => $buildingArray
    ];
} else {
    $data = [
        'message' => 'Error retrieving building detail.',
        'error' => true,
        'buildings' => null
    ];
=======
    $data = array('message' => 'No building found.', 'error' => true);
    return;
>>>>>>> 687186ce63c12151ad5a0841fe40a7d52d448298
}

$building = mysqli_fetch_assoc($result);

$query = 'SELECT * 
    FROM roads 
    WHERE id = "'.$building['road_id'].'" 
    AND city_id = "'.$city_id.'" 
    LIMIT 1';
$result = mysqli_query($connect, $query);

$road = mysqli_fetch_assoc($result);

$query = 'SELECT * 
    FROM cities 
    WHERE id = "'.$city_id.'" 
    LIMIT 1';
$result = mysqli_query($connect, $query);

$city = mysqli_fetch_assoc($result);

$data = [
    'message' => 'Buildings retrieved successfully.',
    'error' => false,
    'building' => $building,
    'road' => $road,
    'city' => $city,
];

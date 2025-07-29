<?php

/*
 *
 * API endpoint to retrieve a list of buldings based on a query
 * URL: https://api.brickmmo.com/map/building/search/city_id/{city_id}/q/{q}
 * 
 */

// Check for required parameters
if(!isset($_GET['city_id']) || !is_numeric($_GET['city_id']))
{
    $data = array('message' => 'No city ID specified.', 'error' => true);
    return;
}
elseif(!isset($_GET['q']))
{
    $data = array('message' => 'No query specified.', 'error' => true);
    return;
}

$city_id = $_GET['city_id'];
$q = $_GET['q'];

$query = 'SELECT * 
    FROM buildings 
    WHERE name LIKE "%'.$q.'%"
    AND city_id = '.$city_id.'
    ORDER BY name
    LIMIT 10';
$result = mysqli_query($connect, $query);

$buildingArray = [];

if(!mysqli_num_rows($result)) 
{
    $data = array('message' => 'No buildings found matching the query.', 'error' => true);
    return;
}

while ($building = mysqli_fetch_assoc($result)) 
{
    $buildingArray[] = [
        'id' => $building['id'],
        'name' => $building['name'],
        'set' => $building['set']
    ];
}

$data = [
    'message' => 'Buildings retrieved successfully.',
    'error' => false,
    'buildings' => $buildingArray
];

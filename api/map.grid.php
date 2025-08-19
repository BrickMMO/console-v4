<?php

/*
 *
 * API endpoint to retrieve the grid of a city.
 * URL: https://api.brickmmo.com/map/grid/city_id/{city_id}
 * 
 */

// Check for required parameters
if(!isset($_GET['city_id']) || !is_numeric($_GET['city_id']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}

// Place URL parameters into variables
$city_id = $_GET['city_id'];

$query = "SELECT squares.*,
    buildings.name,
    buildings.set,
    buildings.colour,
    buildings.number,
    (
            SELECT COUNT(DISTINCT road_square.road_id)
        FROM road_square
        WHERE road_square.square_id = squares.id
    ) AS roads,
    (
        SELECT GROUP_CONCAT(DISTINCT roads.name SEPARATOR ', ')
        FROM road_square
        LEFT JOIN roads ON roads.id = road_square.road_id
        WHERE road_square.square_id = squares.id
    ) AS road_names,
    (
        SELECT COUNT(DISTINCT(track_id))
        FROM square_track
        WHERE square_track.square_id = squares.id
    ) AS tracks,
    (
        SELECT GROUP_CONCAT(DISTINCT tracks.name SEPARATOR ', ')
        FROM square_track
        LEFT JOIN tracks ON tracks.id = square_track.track_id
        WHERE square_track.square_id = squares.id
    ) AS track_names
    FROM squares 
    LEFT JOIN buildings
    ON buildings.id = squares.building_id
    WHERE squares.city_id = $city_id";
$result = mysqli_query($connect, $query);

$squareArray = [];

while ($square = mysqli_fetch_assoc($result)) {

    $newSquare = array();
    $newSquare['id'] = $square['id'];
    $newSquare['x'] = $square['x'];
    $newSquare['y'] = $square['y'];
    $newSquare['road_rules'] = $square['road_rules'];
    $newSquare['track_rules'] = $square['track_rules'];
    $newSquare['type'] = $square['type'];
    $newSquare['city_id'] = $square['city_id'];

    $newSquare['roads'] = $square['roads'];
    $newSquare['tracks'] = $square['tracks'];
    $newSquare['road_names'] = $square['road_names'];
    $newSquare['track_names'] = $square['track_names'];

    if($square['building_id'])
    {
        $newSquare['building']['id'] = $square['building_id'];
        $newSquare['building']['name'] = $square['name'];
        $newSquare['building']['set'] = $square['set'];
        $newSquare['building']['colour'] = $square['colour'];
        $newSquare['building']['number'] = $square['number'];
    }

    $squareArray[] = $newSquare;
}

$data = array(
    'message' => 'City grid retrieved successfully.',
    'error' => false, 
    'squares' => $squareArray,
);
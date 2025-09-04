<?php

// Ensure only one response is sent
if (headers_sent()) {
    exit();
}

// Get building ID and city ID from the URL
// $building_id = isset($_GET['building_id']) ? intval($_GET['building_id']) : null;
$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;


    $query = "SELECT squares.*,
        buildings.name,
        buildings.set,
        buildings.colour,
        buildings.square_id,
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
            $newSquare['building']['square_id'] = $square['square_id'];
        }

        $squareArray[] = $newSquare;
    }

    $data = array(
        'message' => 'QR codes retrieved successfully.',
        'error' => false, 
        'squares' => $squareArray,
    );
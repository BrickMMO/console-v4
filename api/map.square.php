<?php

// Ensure only one response is sent
if (headers_sent()) {
    exit();
}

// Get building ID and city ID from the URL
// $building_id = isset($_GET['building_id']) ? intval($_GET['building_id']) : null;
$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;


    $query = "SELECT * FROM squares WHERE city_id = $city_id";


$result = mysqli_query($connect, $query);

$squareArray = [];


    while ($square = mysqli_fetch_assoc($result)) {

        // Check for buildings
        if($square['building_id'])
        {
            $query = "SELECT * 
                            FROM buildings 
                            LEFT JOIN road_square ON road_square.road_id = buildings.road_id 
                            LEFT JOIN square_images ON square_images.square_id = road_square.square_id 
                            WHERE buildings.id = {$square['building_id']}";
            $result2 = mysqli_query($connect, $query);
            $square['building'] = mysqli_Fetch_assoc($result2);
        }

        // Check for roads
        if($square['city_id'])
        {
            $query = "SELECT * 
                            FROM road_square 
                            LEFT JOIN squares ON squares.id = road_square.square_id
                            LEFT JOIN roads ON roads.id = road_square.road_id 
                            LEFT JOIN square_images ON square_images.square_id = road_square.square_id
                            WHERE road_square.square_id = {$square['id']}";
            $result3 = mysqli_query($connect, $query);
            $square['road'] = mysqli_Fetch_assoc($result3);
        }

        // Check fot tracks
        if($square['city_id'])
        {
            $query = "SELECT * 
                                FROM square_track 
                                LEFT JOIN squares ON square_track.square_id = squares.id 
                                LEFT JOIN tracks ON tracks.id = square_track.track_id 
                                LEFT JOIN square_images ON square_images.square_id = square_track.square_id
                                WHERE square_track.square_id = {$square['id']}";
            $result4 = mysqli_query($connect, $query);
            $square['track'] = mysqli_Fetch_assoc($result4);
        }

        $squareArray[] = $square;
    }


    $data = array(
        'message' => 'QR codes retrieved successfully.',
        'error' => false, 
        'squares' => $squareArray,
    );
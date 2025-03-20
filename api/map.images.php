<?php

// Ensure only one response is sent
if (headers_sent()) {
    exit();
}

// Get building ID and city ID from the URL
// $building_id = isset($_GET['building_id']) ? intval($_GET['building_id']) : null;
$city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;
$square_id = isset($_GET['square_id']) ? intval($_GET['square_id']) : null;
$direction = isset($_GET['direction']) ? $_GET['direction'] : null;

$query = "SELECT image FROM square_images WHERE square_id = $square_id  AND direction = '$direction'";


$result = mysqli_query($connect, $query);

$squareArray = [];

while ($square = mysqli_fetch_assoc($result)) {

    $newSquare = [
        'id' => $square_id,
        'city_id' => $city_id,
        'directions' => $direction,
        'image' => $square['image']
    ];

//     if($square['roads'] > 0 || $square['tracks'] > 0)
//         {

//             $newImages = array();
            
//             $query = "SELECT direction, image FROM square_images WHERE square_id = {$square['id']}";

//             $result2 = mysqli_query($connect, $query);

//             while ($image = mysqli_fetch_assoc($result2)) {
                
//                 // echo 'here';
//                 $direction = $image['direction'];
//                 $image_url = $image['image'];
//                 $newSquare['images'][$direction] = $image_url;
//            }
//         }
$squareArray[] = $newSquare;

}
$data = array(
    'message' => 'QR codes retrieved successfully.',
    'error' => false, 
    'squares' => $squareArray,
);
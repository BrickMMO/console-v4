<?php

// Ensure only one response is sent
if (headers_sent()) {
    exit();
}

// Get the building ID from the URL path
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id) {
    // Query for a specific building
    // URL: http://local.api.brickmmo.com:7777/map/building/id/{IDNumber}
    $query = "SELECT * FROM buildings WHERE id = $id LIMIT 1";
} else {
    // Query for all buildings if no ID is provided
    // URL: http://local.api.brickmmo.com:7777/map/building
    $query = "SELECT * FROM buildings ORDER BY name";
}

$result = mysqli_query($connect, $query);

$buildingArray = [];

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
}

// Set JSON header and output response once
header('Content-Type: application/json');
echo json_encode($data);
exit(); // Prevents any additional output
?>

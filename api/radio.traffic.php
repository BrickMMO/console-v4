<?php

if(!isset($_GET['key']) || !is_numeric($_GET['key']))
{
    $data = array('message' => 'No city ID specified.', 'error' => false);
    return;
}

$query = 'SELECT *,(
    SELECT COUNT(*)
    FROM squares
    INNER JOIN coords
    ON squares.x = coords.x
    AND squares.y = coords.y
    INNER JOIN road_square
    ON squares.id = road_square.square_id
    WHERE road_square.road_id = roads.id 
) AS cars,(
    SELECT COUNT(*)
    FROM squares
    INNER JOIN road_square
    ON squares.id = road_square.square_id
    WHERE road_square.road_id = roads.id
) AS squares
FROM roads
WHERE city_id = "'.$_GET['key'].'"
ORDER BY name';
$result = mysqli_query($connect, $query);

$data = array();

while($road = mysqli_fetch_assoc($result))
{

    $data[] = array(
        'road' => $road['name'],
        'squares' => $road['squares'],
        'cars' => $road['cars'],
        'percent' => round($road['cars']/$road['squares']*100),
    );

}

$data = array(
    'message' => 'Traffic has been loaded.',
    'error' => false, 
    'traffic' => $data,
);


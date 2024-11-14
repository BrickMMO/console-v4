<?php

function square_fetch($identifier)
{

    if(!$identifier) return false;

    global $connect;

    $query = 'SELECT *
        FROM squares
        WHERE id = "'.addslashes($identifier).'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) $square = mysqli_fetch_assoc($result);
    else return false;

    $query = 'SELECT *
        FROM square_images
        WHERE square_id = "'.$identifier.'"';
    $result = mysqli_query($connect, $query);

    while($image = mysqli_fetch_assoc($result))
    {
        $square[$image['direction']] = $image['image'];
    }

    return $square;

}

function square_colour($id, $data = array())
{

    global $connect;

    $query = 'SELECT *
        FROM squares
        WHERE id = "'.$id.'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) 
    {
        $road = mysqli_fetch_assoc($result);

        // If road is current road
        if(isset($data['road_id']) and $data['road_id'] == $road['road_id'])
        {
            return 'dark-grey';
        }
        // If road is specidifed btu square is other road
        elseif(isset($data['road_id']) and $road['road_id'])
        {
            return 'grey';
        }
        // If roads are true and this square is a road
        elseif(isset($data['roads']) and $road['road_id'])
        {
            return 'grey';
        }
        elseif($road['type'] == 'ground')
        {
            return 'brown';
        }
        elseif($road['type'] == 'water')
        {
            return 'blue';
        }
    }
    else return false;
}

function squares_fetch_all($id)
{

    global $connect;

    $city = city_fetch($id);

    $query = 'SELECT *
        FROM squares
        WHERE city_id = '.$id.'
        ORDER BY y,x';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        return squares_set($id);
    }

    while($record = mysqli_fetch_assoc($result))
    {
        $data[$record['y']][$record['x']] = $record;
    }

    return $data;

}

function squares_set($id)
{

    global $connect;

    $query = 'DELETE FROM squares
        WHERE city_id = '.$id;
    mysqli_query($connect, $query);    

    $city = city_fetch($id);

    for($row = 0; $row < $city['height']; $row ++)
    {
        for($col = 0; $col < $city['width']; $col ++)
        {
            $query = 'INSERT INTO squares (
                    x,
                    y,
                    city_id,
                    created_at,
                    updated_at
                ) VALUES (
                    '.$col.',
                    '.$row.',
                    '.$id.',
                    NOW(),
                    NOW()
                )';
            mysqli_query($connect, $query);
        }

    }

    return squares_fetch_all($id);

}
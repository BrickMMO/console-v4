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

    $square['images'] = mysqli_num_rows($result);

    $square['roads'] = square_roads($square['id'], true);
    
    return $square;

}

function square_colour($id, $data = array())
{

    $square = square_fetch($id);

    if($square) 
    {

        // If road is current road
        if(isset($data['road_id']) and in_array($data['road_id'], $square['roads']))
        {
            return 'dark-grey';
        }
        // If road is specified and square is a road
        elseif(isset($data['roads']) and count($square['roads']))
        {
            return 'grey';
        }

        /*
        // If track is current track
        if(isset($data['track_id']) and $data['track_id'] == $road['track_id'])
        {
            return 'dark-grey';
        }
        // If road is specidifed btu square is other road
        elseif(isset($data['track_id']) and $road['track_id'])
        {
            return 'grey';
        }
        // If roads are true and this square is a road
        elseif(isset($data['tracks']) and $road['track_id'])
        {
            return 'grey';
        }
        */
        
        elseif($square['type'] == 'ground')
        {
            return 'brown';
        }
        elseif($square['type'] == 'water')
        {
            return 'blue';
        }
    }
    else return false;
}

function square_roads($id, $array = false)
{

    global $connect;

    $query = 'SELECT *
        FROM road_square
        WHERE square_id = "'.$id.'"';
    $result = mysqli_query($connect, $query);

    $roads = array();

    if($array) 
    {
        while($record = mysqli_fetch_assoc($result))
        {
            $roads[] = $record['road_id'];
        }
    }
    else
    {
        while($record = mysqli_fetch_assoc($result))
        {
            $roads[] = $record;
        }
    }
    
    $roads = array_filter($roads);

    return $roads;

}

function squares_fetch_all($id)
{

    global $connect;

    $city = city_fetch($id);

    $query = 'SELECT *,(
            SELECT COUNT(*)
            FROM square_images
            WHERE squares.id = square_id
        ) AS images
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
        $record['roads'] = square_roads($record['id'], true);
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
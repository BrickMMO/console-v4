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
    $square['tracks'] = square_tracks($square['id'], true);
    
    return $square;

}

function square_colour($id, $data = array())
{

    $square = square_fetch($id);

    if($square) 
    {

        // If track is current track
        if(isset($data['track_id']) and in_array($data['track_id'], $square['tracks']))
        {
            return 'red';
        }
        // If track is specified and square is a track
        elseif(isset($data['tracks']) and count($square['tracks']))
        {
            return 'dark-grey';
        }

        // If road is current road
        elseif(isset($data['road_id']) and in_array($data['road_id'], $square['roads']))
        {
            return 'red';
        }
        // If road is specified and square is a road
        elseif(isset($data['roads']) and count($square['roads']))
        {
            return 'grey';
        }        

        // If road is current building
        elseif(isset($data['building_id']) and $data['building_id'] == $square['building_id'])
        {
            return 'red';
        }
        // If building is specified and square is a building
        elseif(isset($data['buildings']) and $square['building_id'])
        {
            return 'grey';
        }        
        
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

function square_tracks($id, $array = false)
{

    global $connect;

    $query = 'SELECT *
        FROM square_track
        WHERE square_id = "'.$id.'"';
    $result = mysqli_query($connect, $query);

    $tracks = array();

    if($array) 
    {
        while($record = mysqli_fetch_assoc($result))
        {
            $tracks[] = $record['track_id'];
        }
    }
    else
    {
        while($record = mysqli_fetch_assoc($result))
        {
            $tracks[] = $record;
        }
    }
    
    $tracks = array_filter($tracks);

    return $tracks;

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
        $record['tracks'] = square_tracks($record['id'], true);
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
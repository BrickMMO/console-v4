<?php

$minute = (date('i') % 15);
$minute_string = str_pad(date('i') % 15, 2, '0', STR_PAD_LEFT);
$minute_start = floor(date('i') / 15) * 15;
$minute_last = 0;

/**
echo 'Current Min: '.$minute.'<br>';
echo 'Padded: '.$minute_string.'<br>';
echo 'Start: '.$minute_start.'<br>';
/**/

$query = 'SELECT schedules.*,
    schedule_types.name AS type_name
    FROM schedules
    INNER JOIN schedule_types
    ON schedules.type_id = schedule_types.id
    WHERE city_id = "'.$_city['id'].'"
    ORDER BY minute <= "'.$minute_string.'", minute';
$schedules = mysqli_query($connect, $query);

$counter = 0;
$data = array();

while($schedule = mysqli_fetch_assoc($schedules))
{

    /**/
    echo '<hr>';
    debug_pre($schedule);
    /**/

    $query = 'SELECT *
        FROM schedule_logs
        WHERE play_at > "'.date_now().'"
        AND schedule_id = "'.$schedule['id'].'"
        ORDER BY play_at ASC';
    $logs = mysqli_query($connect, $query);

    echo $query.'<br>';
    echo 'Rows: '.mysqli_num_rows($logs).'<br>';
    echo 'Date: '.date('Y-m-d H:i:s').'<br>';

    $minute_next = $schedule['minute'] + $minute_start;

        if($minute_next < $minute_last) $minute_next += 15;
        echo 'Last: '.$minute_last.'<br>';
        echo 'Next: '.$minute_next.'<br>';

        $play_at = date('Y-m-d H:i:00', strtotime(date('Y-m-d H:'.$minute_next.':00')));
        echo 'Play: '.$play_at.'<br>';

    if(!mysqli_num_rows($logs))
    {

        $script = 'Testing a script...';
        
        

        
        

        $query = 'INSERT INTO schedule_logs (
                name,
                script,
                schedule_id,
                city_id,
                play_at,
                created_at,
                updated_at
            ) VALUES (
                "'.$schedule['type_name'].' at '.$schedule['minute'].'",
                "'.$script.'",
                "'.$schedule['id'].'",
                "'.$schedule['city_id'].'",
                "'.$play_at.'",
                "'.date_now().'",
                "'.date_now().'"
            )';

        echo $query.'<br>';

        mysqli_query($connect, $query);

        
        
        $id = mysqli_insert_id($connect);

        $query = 'SELECT *
            FROM schedule_logs
            WHERE id = "'.$id.'"
            LIMIT 1';
        $result = mysqli_query($connect, $query);

        $data[] = mysqli_fetch_assoc($result);

        

        $counter ++;

    }

    $minute_last = $minute_next;
    
}

$data = array(
    'message' => $counter.' new radio logs have been scheduled.',
    'error' => false, 
    'stores' => $data
);
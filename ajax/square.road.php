<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['road_id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$query = 'UPDATE squares SET
    road_id = "'.addslashes($_POST['road_id']).'"
    WHERE id = '.addslashes($_POST['id']).'
    LIMIT 1';
mysqli_query($connect, $query);

$data = array('message' => 'Square has been updated.', 'error' => false);
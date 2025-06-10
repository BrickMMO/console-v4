<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['building_id']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$query = 'UPDATE buildings SET 
    square_id = '.$_POST['id'].'
    WHERE id = "'.$_POST['building_id'].'"
    LIMIT 1';
mysqli_query($connect, $query);

$data = array('message' => 'Square has been updated.', 'error' => false);
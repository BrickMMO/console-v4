<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['road_rules']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$query = 'UPDATE squares SET
    road_rules = "'.addslashes($_POST['road_rules']).'"
    WHERE id = "'.addslashes($_POST['id']).'"
    LIMIT 1';
mysqli_query($connect, $query);

$data = array('message' => 'Square road rules has been updated.', 'error' => false);
<?php

if(
    !isset($_POST['id']) || 
    !isset($_POST['track_rules']))
{
    header_bad_request();
    $data = array('message'=>'Missing Paramater.', 'error' => true);
    return;
}

$query = 'UPDATE squares SET
    track_rules = "'.addslashes($_POST['track_rules']).'"
    WHERE id = "'.addslashes($_POST['id']).'"
    LIMIT 1';
mysqli_query($connect, $query);

$data = array('message' => 'Square track rules has been updated.', 'error' => false);
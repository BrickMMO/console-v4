<?php


$length = 1;
$filename = basename(__FILE__);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: events.';

// get event data when db ready

$prompt .='Write two latest news items about Canadian cities, about population, buildings, transportation and other living things.';
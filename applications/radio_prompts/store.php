<?php

$length = 1;
$filename = basename(__FILE__);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 

There is one host for the radio station.'; 

// HOST information $_city
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .='Only include the words the host will say, no instructions, no music or sounds.
The topic of this segment is store. 
';

$prompt .='Write a script of LEGO City Stores ';


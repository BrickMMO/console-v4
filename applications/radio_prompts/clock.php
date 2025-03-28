<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. '; 

$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. 

The topic of this segment is the current date and time. Include one funny joke.

The current time is '.$log['play_at'].'.

Include some laughter.

';

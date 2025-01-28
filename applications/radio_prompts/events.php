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
$prompt .='The recent LEGO City Live Music Festival was a roaring success, with unforgettable performances lighting up the city. The grand finale by the legendary Brickharmonics left the crowd buzzing with excitement, making it a weekend to remember.

Looking ahead, do not miss the Color Run happening this Saturday! The race kicks off at 9 AM from Central Park, with participants running through colorful powder stations and finishing with a lively celebration featuring music, food stalls, and fun games. Next Thursday, winter sports enthusiasts can head to Snowflake Summit for the annual Ski Challenge, starting at 10 AM. Whether you are racing down the slopes or enjoying hot cocoa by the lodge, it is an event for everyone';
<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: crypto.

Write a script based on the introduction as below using radio speaking style.
';

$prompt .='In the LEGO City universe, virtual currency plays a pivotal role in facilitating seamless transactions and enhancing everyday life across various sectors. Residents and visitors use this digital currency to pay for public transportation, making commutes efficient and cashless. Shops and markets accept virtual payments for goods, ensuring a quick and hassle-free shopping experience. Hotels in LEGO City utilize the currency for reservations and room services, streamlining check-ins and enhancing customer convenience.

The police department employs the currency to manage fines and streamline administrative processes, promoting efficiency in law enforcement. Banks act as digital currency hubs, offering services like account management, virtual loans, and secure transactions, eliminating the need for physical cash. Popular attractions and landmarks accept virtual payments for entry fees, souvenirs, and guided tours, enriching the tourist experience.

By integrating virtual currency into the city ecosystem, LEGO City ensures a fast, secure, and eco-friendly way of conducting transactions, reducing reliance on physical money and fostering a connected, futuristic urban lifestyle.';
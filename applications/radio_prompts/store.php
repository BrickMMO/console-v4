<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 

There is one host for the radio station.'; 

// HOST information $_city
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .='Only include the words the host will say, no instructions, no music or sounds. The topic of this segment is store. 

Here is a list of each store, country, and how many stores are currently in the country:
';

$query='SELECT countries.*, 
    COUNT(stores.store_id) AS store_count,
    GROUP_CONCAT(stores.name ORDER BY stores.name SEPARATOR ",") AS store_names
    FROM countries
    LEFT JOIN stores ON stores.country_id=countries.id
    WHERE stores.name IS NOT NULL
    GROUP BY countries.id';

    $result = mysqli_query($connect, $query);  

    while ($stores = mysqli_fetch_assoc($result)) {    
        $prompt .='There have been ' . $stores['store_count'] . ' stores in ' . $stores['long_name'] . '. They are ' .   $stores['store_names'];
    }


$prompt .='Write a script of LEGO City Stores.

Instead of referring to the exact number or percentage of stores, use these data to gauge which countries should be included in the report and how well the store facilities in that country have developed. The report does not need to include every country.
';


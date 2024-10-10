<?php


$google = setting_fetch('GOOGLE_ACCESS_TOKEN');
$google = json_decode($google, true);

$image = setting_fetch('GOOGLE_DRIVE_VIDEO', 'comma_2_array');

google_list_files($google, $image[0], $image[1]);


debug_pre($google);
debug_pre($image);

die();


// Call the function to list files in a specific folder
google_list_files('STOCK_VIDEO');


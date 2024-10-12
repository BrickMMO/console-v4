<?php

if(!isset($_GET['key']) || !$_GET['key'])
{
    message_set('Google API Error', 'There was an error importing Google Drive media.', 'red');
    header_redirect('/admin/media/dashboard');
}

$google = setting_fetch('GOOGLE_ACCESS_TOKEN');
$google = json_decode($google, true);

if($_GET['key'] == 'audio') $setting = 'GOOGLE_DRIVE_AUDIO';
elseif($_GET['key'] == 'image') $setting = 'GOOGLE_DRIVE_IMAGE';
elseif($_GET['key'] == 'video') $setting = 'GOOGLE_DRIVE_VIDEO';

$folder = setting_fetch($setting, 'comma_2_array');
$type = $_GET['key'];

if($_GET['key'] == 'audio') $redirect = 'audio';
elseif($_GET['key'] == 'image') $redirect = 'images';
elseif($_GET['key'] == 'video') $redirect = 'video';


try
{
    $files = google_list_files($google, $folder[0], $folder[1]);
}
catch(Exception $e)
{
    message_set('Google API Error', 'Google Access Token has expired.', 'red');
    header_redirect('/admin/authentication  /dashboard');
}

$images = 0;

foreach($files as $key => $file)
{
    $query = 'SELECT *
        FROM media 
        WHERE google_id = "'.$file['google_id'].'"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {

        $query = 'INSERT INTO media (
                name,
                type,
                google_id,
                city_id,
                user_id
            ) VALUES (
                "'.$file['name'].'",
                "'.$file['type'].'",
                "'.$file['google_id'].'",
                "'.$_city['id'].'",
                "'.$_user['id'].'"
            )';
        mysqli_query($connect, $query); 

        $images ++;

    }

}

message_set(
    'Import Success', 
    'Media from the BrickMMO Google Drive have been imported. '.
    'Imported '.$images.' new images.'
);
header_redirect(ENV_CONSOLE_DOMAIN.'/admin/media/'.$redirect);


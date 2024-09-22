<?php

use Google\Client;
use Google\Service\Drive;

function google_display_token($token)
{
    return str_repeat('*', strlen($token));
}

function googl_get_client($access_token = false)
{

    $client = new Client();
    // $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setApplicationName('BrickMMO');
    $client->setScopes(Drive::DRIVE_METADATA_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    // $client->setRedirectUri('http://localhost:8888/callback.php');
    $client->setRedirectUri(ENV_ACCOUNT_DOMAIN.'/action/google/app/token');

    if ($access_token) 
    {
        $client->setAccessToken($access_token);
    }

    return $client;

}

function google_auth_url($access_token)
{

    $client = googl_get_client($access_token);
    $auth_url = $client->createAuthUrl();
    return $auth_url;
    
}
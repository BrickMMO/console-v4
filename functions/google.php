<?php

use Google\Client;
use Google\Service\Drive;
use Google\Service\Gmail;

function google_display_token($token)
{
    return substr(str_repeat('X', strlen($token)), 0, 30);
}

function google_revoke($access_token)
{

    

}

function googl_get_client($access_token = false)
{

    $client = new Client();
    // $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setApplicationName('BrickMMO');
    $client->setScopes(Drive::DRIVE_METADATA_READONLY,Gmail::GMAIL_READONLY);
    $client->setAuthConfig('../credentials.json');
    $client->setAccessType('offline');
    // $client->setRedirectUri('http://localhost:8888/callback.php');
    // $client->setRedirectUri(ENV_ACCOUNT_DOMAIN.'/action/google/add/token');
    $client->setRedirectUri('https://local.account.brickmmo.com:7777/action/google/add/token');

    /**
     * If access token is provided, use it to initiate the client.
     */
    if ($access_token) 
    {
        $client->setAccessToken($access_token);
    }

    /**
     * If access token is in the session, this page load is fresh off a Google authtication
     * callback, and use the session token.
     */
    elseif(isset($_SESSION['access_token']))
    {
        $client->setAccessToken($_SESSION['access_token']['access_token']);
    }

    return $client;

}

function google_auth_url()
{

    $client = googl_get_client();
    $auth_url = $client->createAuthUrl();
    return $auth_url;

}
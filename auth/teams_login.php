<?php
require '../config/database.php';
require '../vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;

$provider = new GenericProvider([
    'clientId'                => 'TON_CLIENT_ID',
    'clientSecret'            => 'TON_CLIENT_SECRET',
    'redirectUri'             => 'http://localhost/auth/callback.php',
    'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
    'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
    'scopes'                  => 'User.Read'
]);

$authUrl = $provider->getAuthorizationUrl();
session_start();
$_SESSION['oauth2state'] = $provider->getState();

header('Location: ' . $authUrl);
exit;

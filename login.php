<?php
session_start();
use League\OAuth2\Client\Provider\Google;
include 'vendor/autoload.php';

$provider = new Google([
    // client ID, client Secret dan redirect Url diseting di google console
    'clientId'     => '158212854784-m613suabiuh7u83h3jgdoa3l0qmsohbv.apps.googleusercontent.com',
    'clientSecret' => 'DeXOI4MvGbLzrYY0-3S1jsEV',
    'redirectUri'  => 'http://localhost/lp3i/raven/login.php'
]);

if (!empty($_GET['error'])) {

    // Error akses tidak diberikan
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));

} elseif (empty($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        //
        $_SESSION['login'] = $ownerDetails->toArray();

        header("location: index.php");

    } catch (Exception $e) {

        // Failed to get user details
        exit('Something went wrong: ' . $e->getMessage());

    }
}
?>
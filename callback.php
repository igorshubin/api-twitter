<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

/* If the oauth_token is old redirect to the start page. */
if (isset($_REQUEST['oauth_token']) && !$twitter->validRequestToken( $_REQUEST['oauth_token'] ))
    $twitter->redirect('/logout.php');

/* Request main access tokens from twitter */
$access_token = $twitter->refreshAccessToken( $_REQUEST['oauth_verifier'] );

/* Save the access tokens. Normally these would be saved in a database for future use. */
$twitter->saveAccessToken($access_token);

// redirect to start page
$twitter->redirect('/');

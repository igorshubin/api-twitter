<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

/* Get temporary credentials. */
$request_token = $twitter->getRequestToken( OAUTH_CALLBACK );

/* Save temporary credentials to session. */
$twitter->saveOAuthToken( $request_token );

/* Get token for auth url */
$token = $request_token['oauth_token'];

// if connection code ok - redirect to auth url
if ($twitter->http_code == 200) {
    $twitter->redirect( $twitter->getAuthorizeURL($token) );
} else {
    echo 'Could not connect to Twitter. Refresh the page or try again later.';
    exit;
}

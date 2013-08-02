<?php
require_once('src/twitteroauth.php');

/* Build TwitterOAuth object with client credentials. */
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
$twitter->logOut( '/' );


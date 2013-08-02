<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

if ($twitter->isLogged())
    $twitter->redirect( '/profile.php' );

?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Twitter API</title>

<link rel="stylesheet" href="/css/reset.css" type="text/css" />
<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="/css/style.css" type="text/css" />

<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.js"></script>

</head>


<body>

<div id="main" class="container">
   <div class="content">    
    
        <div class="page-header">
            <h3>Twitter API</h3>
            <a href="/login.php" class="btn primary large">Login To Twitter</a>
        </div>
       
       <div class="row span3 well" style="margin-left: 0">
          
           Please accept all permission requests.
          
      </div>       
       
            
   </div>       
</div>
       
</body>
</html>

<?php

//$twitter->debug();
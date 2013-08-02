<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

if (!$twitter->isLogged())
    $twitter->redirect ('/');

// https://dev.twitter.com/docs/api/1.1
/* Some example calls */
//$twitter->get('users/show', array('screen_name' => 'abraham'));
//$twitter->post('statuses/update', array('status' => date(DATE_RFC822)));
//$twitter->post('statuses/destroy', array('id' => 5437877770));
//$twitter->post('friendships/create', array('id' => 9436992));
//$twitter->post('friendships/destroy', array('id' => 9436992));


// get user info
$user = $twitter->get('account/verify_credentials');
$user = $twitter->toArray($user);
extract($user);


// get user account settings
$settings = $twitter->get('account/settings');
$settings = $twitter->toArray($settings);

// rate limit exceeded
if (isset($user['errors'])) {
    echo '<pre>';
    print_r($twitter->getRateLimit());
    echo '</pre>';
    exit;    
}

//echo '<pre>';
//print_r($user);
//exit;

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
           <h3>Twitter User Profile</h3>
           
            <?php require_once '_menu.php'; ?>
           
        </div>
       
       
       
       <div class="row data_wrap">
             <h4><?php echo $name; ?>'s Profile</h4>
             
                <div class="data_line">
                   

                    <div class="row data_photo">
                       <div class="span2">
                           <a target="_blank" href="https://twitter.com/<?php echo $screen_name; ?>">
                                <img src="<?php echo $profile_image_url; ?>" alt="<?php echo $id; ?>"/>
                           </a>
                       </div>
                       <div class="span9">
                           <ul>
                               <li><strong>ID:</strong> <?php echo $id; ?></li>
                               <li><strong>Username:</strong> <?php echo $screen_name; ?></li>
                               <li><strong>Full Name:</strong> <?php echo $name; ?></li>
                               <li><strong>Location:</strong> <?php echo ($location)? $location : '&nbsp;' ?></li>
                               <li><strong>Description:</strong> <?php echo ($description)? $description : '&nbsp;' ?></li>
                               <li><strong>Followers:</strong> <?php echo $followers_count; ?></li>
                               <li><strong>Friends:</strong> <?php echo $friends_count; ?></li>
                           </ul>
                       </div>
                    </div>

                    <div class="row data_action">
                        <div class="pull-right">
                            <a target="_blank" href="https://twitter.com/<?php echo $screen_name; ?>" class="btn btn-mini">View Page</a>
                        </div> 
                    </div>
                    
                    <div class="row data_raw">
                        <a class="pull-right" onclick="$('#post_<?php echo $id; ?>').slideToggle()" href="javascript:void(0)">[ Raw data ]</a>
                        <div class="clearfix"></div>
                        <div id="post_<?php echo $id; ?>" class="hide"><pre><?php print_r($user); ?></pre></div>
                        <div class="clearfix"></div>
                    </div>                    
                    
                </div>
             
      </div>       
       
       
       <div class="row data_wrap">
             <h4>Account Settings</h4>
             
                <div class="data_line">
                   
                    <div class="row data_raw">
                        <a class="pull-right" onclick="$('#post_settings').slideToggle()" href="javascript:void(0)">[ Raw data ]</a>
                        <div class="clearfix"></div>
                        <div id="post_settings" class="hide"><pre><?php print_r($settings); ?></pre></div>
                        <div class="clearfix"></div>
                    </div>                    
                    
                </div>
             
      </div>        
       
       
   </div>
</div>
    
    
</body>
</html>

<?php

//$twitter->debug();
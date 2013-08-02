<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

if (!$twitter->isLogged())
    $twitter->redirect ('/');


// get data
$type = (isset($_GET['type']))? $_GET['type'] : 'friends';

if ($type == 'friends')
    $data = $twitter->get('friends/list');

if ($type == 'followers')
    $data = $twitter->get('followers/list');

$data = $twitter->toArray($data);

//echo '<pre>';
//print_r($data);
//echo '</pre>';
//exit;

$count=0;
$nav = ($data['next_cursor'] || $data['previous_cursor'])? true : false;

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
           <h3>Twitter <?php echo ucfirst($type); ?> List</h3>
           
            <?php require_once '_menu.php'; ?>
           
        </div>
       
       
       
       <div class="row data_wrap">
            <h4><?php echo ucfirst($type); ?> List</h4>
             
             <?php if (count($data['users'])): ?>
             <?php foreach($data['users'] as $post): ?>
             <?php $post = $twitter->toArray($post); ?>
             <?php $count++; ?>
             
                <div class="data_line">
                    
                    <div class="row data_photo">
                       <div class="span2">
                            <a target="_blank" href="https://twitter.com/<?php echo $post['screen_name']; ?>">
                             <img src="<?php echo $post['profile_image_url']; ?>" alt=""/>
                            </a>
                       </div>
                       <div class="span9">
                           <ul>
                               <li><strong>ID:</strong> <?php echo $post['id']; ?></li>
                               <li><strong>User:</strong> <?php echo $post['name']; ?> (<?php echo $post['screen_name']; ?>)</li>
                               <li><strong>Decsription:</strong> <?php echo ($post['description'])? $post['description'] : '&nbsp;' ?></li>
                               <li><strong>Followers count:</strong> <?php echo $post['followers_count']; ?></li>
                               <li><strong>Friends count:</strong> <?php echo $post['friends_count']; ?></li>
                               <li><strong>Listed count:</strong> <?php echo $post['listed_count']; ?></li>
                           </ul>
                       </div>
                    </div>

                    <div class="row data_action">
                        <div class="pull-right">
                            <form action="/feed_post.php" method="post" id="post_form_<?php echo $post['id'] ?>">
                                <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                                <input type="hidden" name="action" id="action_<?php echo $post['id'] ?>" value="">
                                <!--
                                <input type="text" name="comment" id="comment_<?php echo $post['id'] ?>" value="" style="margin: 0;">
                                <a onclick="post_comment('<?php echo $post['id'] ?>');" href="javascript:void(0)" class="btn btn-mini btn-warning">Comment</a>
                                ::
                                <a onclick="post_like('<?php echo $post['id'] ?>');" href="javascript:void(0)" class="btn btn-mini btn-info">Post Like</a>
                                ::
                                -->
                                <?php if ($post['url']): ?>
                                    <a target="_blank" href="<?php echo $post['url'] ?>" class="btn btn-mini">View Page</a>
                                <?php endif; ?>
                            </form>
                        </div> 
                    </div>
                    
                    <div class="row data_raw">
                        <a class="pull-right" onclick="$('#post_<?php echo $post['id']; ?>').slideToggle()" href="javascript:void(0)">[ Raw data ]</a>
                        <div class="clearfix"></div>
                        <div id="post_<?php echo $post['id']; ?>" class="hide"><pre><?php print_r($post); ?></pre></div>
                        <div class="clearfix"></div>
                    </div>                    
                    
                </div>
             
             <?php endforeach ?>
             <?php endif; ?>
           
      </div>       
       
       
       <?php if ($nav):  ?>
       <div class="row">
           
            <ul class="pager">
                <ul>
                    <li><a href="<?php echo $data['next_cursor']; ?>">Prev</a></li>
                    <li class=""><a href="<?php echo $data['previous_cursor']; ?>">Next</a></li>
                </ul>
            </ul>
           
           <div class="clearfix"></div>
           
       </div>
       <?php endif ?>
       
       
       <div class="row data_wrap">
           <div style="margin-top: 5px;"><a class="pull-right" onclick="$('#feed_all').toggle()" href="javascript:void(0)">[ Raw data all ]</a></div>
           <div class="clearfix"></div>
           <div id="feed_all" class="hide"><pre><?php print_r($data); ?></pre></div>
           <div class="clearfix"></div>
       </div>    
       
       
       
   </div>
</div>
    
    
</body>
</html>

<?php

//$twitter->debug();
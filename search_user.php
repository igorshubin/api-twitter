<?php
@session_start();
require_once('src/twitteroauth.php');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

if (!$twitter->isLogged())
    $twitter->redirect ('/');


// get data
$data = array();
$search = false;

if (isset($_POST['q']) || isset($_GET['q'])) {
    
    $search = true;
    $keyword = (isset($_POST['q']))? $_POST['q'] : $_GET['q'];
    $keyword = trim(strip_tags($keyword));
    
    $params = array();
    
        if (count($_POST)) {
            $params = array(
                'q'=>$keyword,
                'count'=>20,
                'include_entities'=>1,
            );
        } else if (count($_GET)) {
            $params = $_GET;
        }
    
    if ($keyword) {
        $data = $twitter->get('users/search',$params);
        $data = $twitter->toArray($data);
    }
    
}


if ($search) {
//    echo '<pre>';
//    print_r($data);
//    echo '</pre>';
//    exit;
}

$count=0;

$nav = (isset($data['search_metadata']) && $data['search_metadata']->next_results)? true : false;


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
           <h3>Twitter Search Results List</h3>
           
            <?php require_once '_menu.php'; ?>
           
        </div>
       
       
       <div class="row data_wrap">
           
            <form method="post" action="" onsubmit="return tag_search()">
             <h4>Search tweets by user</h4>
             <div>
                 <input type="text" name="q" id="q" value="">
             </div>
             <div>
                 <input type="submit" class="btn" value="Search"> &nbsp; 
                 <input type="button" onclick="location.href='<?php echo $_SERVER['SCRIPT_NAME']; ?>'" class="btn" value="Clear Results">
             </div>
            </form>
           
        </div>       
       
       <div class="row data_wrap">
            <h4>Results List</h4>
             
             <?php if (count($data)): ?>
             <?php foreach($data as $post): ?>
             <?php $post = $twitter->toArray($post); ?>
             <?php $count++; ?>
             
                <div class="data_line">
                    
                    <div class="row data_photo">
                       <div class="span2">
                            <a href="#">
                             <img src="<?php echo $post['profile_image_url']; ?>" alt=""/>
                            </a>
                       </div>
                       <div class="span9">
                           <ul>
                               <li><strong>ID:</strong> <?php echo $post['id_str']; ?></li>
                               <li><strong>Date:</strong> <?php echo $post['created_at']; ?></li>
                               <li><strong>User:</strong> <?php echo $post['name']; ?> (<?php echo $post['screen_name']; ?>)</li>
                               <li><strong>Location:</strong> <?php echo ($post['location'])? $post['location'] : '&nbsp;' ?></li>
                               <li><strong>Text:</strong> <?php echo ($post['description'])? $post['description'] : '&nbsp;' ?></li>
                           </ul>
                       </div>
                    </div>

                    <div class="row data_action">
                        <div class="pull-right">
                            <form action="/feed_post.php" method="post" id="post_form_<?php echo $post['id_str'] ?>">
                                <input type="hidden" name="id" value="<?php echo $post['id_str'] ?>">
                                <input type="hidden" name="action" id="action_<?php echo $post['id_str'] ?>" value="">
                                <!--
                                <input type="text" name="comment" id="comment_<?php echo $post['id_str'] ?>" value="" style="margin: 0;">
                                <a onclick="post_comment('<?php echo $post['id_str'] ?>');" href="javascript:void(0)" class="btn btn-mini btn-warning">Comment</a>
                                ::
                                <a onclick="post_like('<?php echo $post['id_str'] ?>');" href="javascript:void(0)" class="btn btn-mini btn-info">Post Like</a>
                                ::
                                -->
                                <a target="_blank" href="<?php echo $post['url'] ?>" class="btn btn-mini">View Page</a>
                            </form>
                        </div> 
                    </div>
                    
                    <div class="row data_raw">
                        <a class="pull-right" onclick="$('#post_<?php echo $post['id_str']; ?>').slideToggle()" href="javascript:void(0)">[ Raw data ]</a>
                        <div class="clearfix"></div>
                        <div id="post_<?php echo $post['id_str']; ?>" class="hide"><pre><?php print_r($post); ?></pre></div>
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
                    <!--
                    <li><a href="<?php echo $data['next_cursor']; ?>">Prev</a></li>
                    -->
                    
                    <li class=""><a href="<?php echo $data['search_metadata']->next_results; ?>">Next</a></li>
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
    
<script> 
    
    function tag_search () {
        
        if (!$('#q').val()) {
            alert('Please type search keyword');
            $('#q').focus();
            return false;
        }
        return true;
    }
    
</script>    
    
</body>
</html>

<?php

//$twitter->debug();
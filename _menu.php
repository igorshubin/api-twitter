
<div class="btn-group">
    <a href="/profile.php" class="btn btn-success small">Profile</a>
</div>

<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-danger small dropdown-toggle">
        Friends
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="/friends.php?type=friends">Friends</a></li>
        <li><a href="/friends.php?type=followers">Followers</a></li>
    </ul>   
</div>

<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-info small dropdown-toggle">
        Tweets
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="/tweets.php?type=user">User Tweets</a></li>
        <li><a href="/tweets.php?type=home">User + Follows Tweets</a></li>
    </ul>   
</div>


<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-warning small dropdown-toggle">
        Search
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="/search_keyword.php">Search By Keyword</a></li>
        <li><a href="/search_user.php">Search By User</a></li>
    </ul>   
</div>


<!--
<div class="btn-group">
    <a href="#" data-toggle="dropdown" class="btn btn-inverse small dropdown-toggle">
        Follows
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="/follow.php?type=FollowedBy">User Followed By</a></li>
        <li><a href="/follow.php?type=Follows">User Follows</a></li>
    </ul>   
</div>   
-->

<a href="/logout.php" class="btn small pull-right" style="margin-right: 5px;">Logout</a> 

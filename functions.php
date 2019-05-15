<?php
session_start();

$host = "shareddb-m.hosting.stackcp.net";
$db = "qwerty-3130315cbf";
$password = "V4101513K";
$link = mysqli_connect($host, $db, $password, $db);
if (mysqli_connect_error()) {
  echo "<b>Failure:</b><br>";
  echo mysqli_connect_error()."<br>";
  die("<b>Unable to connect</b><br>");
  exit();
}

if (array_key_exists('function', $_GET) && $_GET['function'] == "logout") {
  session_unset();
}

function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'y'),
        array(60 * 60 * 24 * 30 , 'mon'),
        array(60 * 60 * 24 * 7, 'w'),
        array(60 * 60 * 24 , 'd'),
        array(60 * 60 , 'h'),
        array(60 , 'min'),
        array(1 , 's')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count{$name}";
    return $print;
}


function displayTweets($type) {
  
  global $link;
  
  if ($type == "public") {
    $whereClause = "";
  } else if ($type == "isFollowing") {
    $whereClause = "";
    $query = "select * from isFollowing where follower=".mysqli_real_escape_string($link, $_SESSION['id']);
  
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      if ($whereClause == "") $whereClause = "where";
      else $whereClause .= " or ";
      $whereClause .= " user_id = ".$row['isFollowing'];
        
    }
    if ($whereClause == "") {
      $whereClause = "where id=-1";
    }
  } else if ($type == "yourtweets") {
    $whereClause = "WHERE user_id=".mysqli_real_escape_string($link, $_SESSION['id']);
  } else if ($type == "search") {
    echo "<p>Showing results for '".mysqli_real_escape_string($link, $_GET['q'])."':</p>";
    $whereClause = "WHERE tweet LIKE '%".mysqli_real_escape_string($link, $_GET['q'])."%'";
  } else if (is_numeric($type)) {
    $whereClause = "where user_id=".mysqli_real_escape_string($link, $type);
  }
   
  $query = "select * from tweets ".$whereClause." order by `date` desc limit 100";
  
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) == 0) {
    echo "<p><i>There are no tweets to display</i></p>";
  } else {
    while ($row = mysqli_fetch_assoc($result)) {
      $userQuery = "select * from tw_users where id = '".mysqli_real_escape_string($link, $row['user_id'])."' limit 1";
      $userQueryResult = mysqli_query($link, $userQuery);
      
      $user = mysqli_fetch_assoc($userQueryResult);
      
      
      $isFollow = "Follow";
      
      if (array_key_exists('id', $_SESSION)) {
        $query = "select * from isFollowing where follower=".mysqli_real_escape_string($link, $_SESSION['id'])." and isFollowing=".mysqli_real_escape_string($link, $user['id'])." limit 1";
  
      $follow = mysqli_query($link, $query);

      if (mysqli_num_rows($follow) > 0) {
         $isFollow = "Unfollow";
      }  
      }
      
      echo "<div class='tweet'>";
      if (array_key_exists('id', $_SESSION) && $_SESSION['id'] != $user['id']) {
        echo "<p id='follow-p'><button class='btn btn-outline-primary toggleFollow' data-userId = '".$row['user_id']."'>".$isFollow."</button></p>"; 
      }
      
      echo "<p id='tweetUsername'><a class='tweetUserLink' href='?page=publicprofiles&user_id=".$row['user_id']."'>".$user['email']."<span class='time'> ".time_since(time() -strtotime($row['date']))." ago</span></a></p>";
      echo "<p>".$row['tweet']."</p></div>";
    }
  }
}

function displaySearch() {
  echo '<form id="searchBar" class="form-inline">
  <div class="form-group">
    <input type="hidden" name="page" value="search">
    <input type="text" name="q" class="form-control" id="search" placeholder="Search Tweets">
  </div>
  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>';
  
  if (array_key_exists('id', $_SESSION)) {
    echo '<button id="newTweetButton" class="btn btn-outline-primary" data-shown="0"><i class="fas fa-plus"></i></button>
    </form>'; 
  } else {
    echo '</form>';
  }
}

function displaySearchUser() {
  echo '<form id="searchBar" class="form-inline">
  <div class="form-group">
    <input type="hidden" name="page" value="search">
    <input type="text" name="q" class="form-control" id="search" placeholder="Search Tweets">
  </div>
  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
</form>';
}

function displayTweetBox() {
  if (array_key_exists('id', $_SESSION)) {
    echo "<div id='tweetBox'>";
    echo '<div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully!</div>
    <div id="tweetFail" class="alert alert-danger"></div>';
    
    echo '<div class="form-group">
    <label for="exampleFormControlTextarea1">New tweet:</label>
    <textarea class="form-control" id="tweetContent" rows="3"></textarea>
  </div>
  <button id="postTweetButton" class="btn btn-primary">Publish</button></div>';
  }
}

function displayUsers() {
  global $link;
  $query = "select * from tw_users";
  
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) == 0) {
    echo "<p><i>There are no tweets to display</i></p>";
  } else {
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<a class="userLink" href="?page=publicprofiles&user_id='.$row['id'].'"><div class="user">
        <p>'.$row['email'].'</p>
      </div></a>';
    }
  }
}
    



?>
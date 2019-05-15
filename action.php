<?php
include("functions.php");

if ($_GET['action'] == "loginSignup") {
  
  $error = "";
  
  if (!$_POST['email']) {
    $error = "An email address is required.";
  } else if (!$_POST['password']) {
    $error = "A password is required.";
  } else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    $error = "Please enter a valid email address.";
  } 
  
  if ($error != "") {
    echo $error;
    exit();
  }
  
  if ($_POST['loginActive'] == '0') {
    $query = "select * from tw_users where email='".mysqli_real_escape_string($link, $_POST['email'])."' limit 1";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
      $error = "That email address is already taken";
    } else {
      $query = "INSERT INTO tw_users (`email`, `password`) values ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, password_hash($_POST['password'], PASSWORD_DEFAULT))."')";
      
      if (mysqli_query($link, $query)) {      
        echo 1;
        
        $_SESSION['id'] = mysqli_insert_id($link);
      } else {
        $error = "Couldn't create user - please try again later"; 
      }
    }
  } else {
    $query = "select * from tw_users where email='".mysqli_real_escape_string($link, $_POST['email'])."' limit 1";
    
    $result = mysqli_query($link, $query);
    
    $row = mysqli_fetch_assoc($result); 
    if (password_verify($_POST['password'], $row['password'])) {
      echo 1;
      $_SESSION['id'] = $row['id'];
    } else {
      $error = "Couldn't find that email/password combination. Please try again.";
    }
    
  }
  
  if ($error != "") {
    echo $error;
    exit();
  }
} 


if ($_GET['action'] == 'toggleFollow') {
  
  $query = "select * from isFollowing where follower=".mysqli_real_escape_string($link, $_SESSION['id'])." and isFollowing=".mysqli_real_escape_string($link, $_POST['user_id'])." limit 1";
  
  $result = mysqli_query($link, $query);
  
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); 
    
    mysqli_query($link, "delete from isFollowing where id=".mysqli_real_escape_string($link, $row['id'])." limit 1");
    
    echo "1";
  } else {
    
    mysqli_query($link, "INSERT INTO isFollowing (follower, isFollowing) values (".mysqli_real_escape_string($link, $_SESSION['id']).", ".mysqli_real_escape_string($link, $_POST['user_id']).")");
    
    echo "2";
  
  }
}

if ($_GET['action'] == 'postTweet') {
  if (!$_POST['tweetContent']) {
    echo "Your tweet is empty!";
  } else if (strlen($_POST['tweetContent']) > 140) {
    echo "Your tweet is too long";
  } else {
    mysqli_query($link, "INSERT INTO tweets (tweet, user_id, date) values ('".mysqli_real_escape_string($link, $_POST['tweetContent'])."', ".mysqli_real_escape_string($link, $_SESSION['id']).", NOW())");
    
    echo "1";
  }
}
?>
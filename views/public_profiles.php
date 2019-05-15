<div class="container mainContainer">
  
  <div class="row">
    <div class="col-md-8">
      <?php 
      if (array_key_exists('user_id', $_GET)) { 
        echo '<h2>User\'s tweets:</h2>
        <div class="tweets">';
        displayTweets($_GET['user_id']);
        echo '</div>';
      } else {
        echo '<h2>Active Users</h2>
        <div class="tweets">';
        displayUsers();
        echo '</div>';
      }?>
    </div>
    <div class="col-md-4">
      <?php 
        displaySearch();
        echo "<hr>";
        displayTweetBox();
      ?>
    </div>
  </div>
  
</div>
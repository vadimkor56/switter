<div class="container mainContainer">
  <div class="row">
    <div class="col-md-8">
      <h2>Tweets For You</h2>
      <div class="tweets">
        <?php displayTweets('isFollowing'); ?>
      </div>
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
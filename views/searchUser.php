<div class="container mainContainer">
  
  <div class="row">
    <div class="col-md-8">
      <h2>Search Results</h2>
      <div class="tweets">
        <?php displayTweets('search'); ?>
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
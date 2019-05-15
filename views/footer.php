    <footer class="footer">
      <div class="container">
        <p>&copy; Vadim Korepanov 2019</p>
      </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalTitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="loginAlert" class="alert alert-danger">
        </div>
        <form>
          <input type="hidden" id="loginActive" name="loginActive" value="1">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="toggleLogin" class="btn btn-outline-success">Sign up</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="loginSignupButton" type="button" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>

<script src='test.js5'></script>
<script>
  $( document ).ready(function() {
    let height = $(window).height() - 202;
    $(".tweets").css('height', height + "px");
    
    if ($(window).width() < 768) {
      let height = $(window).height() - 56;
      $('.mainContainer').css('height', height + "px");
      
      height += 56;
      $('html').css('height', height);
    }
  });
  
  $(window).on('resize', function(){
      var win = $(this); 
      if (win.width() >= 768) {
        $('.mainContainer').css('height', 'auto');
        $('html').css('height', 'auto');
      } else {
        let height = $(window).height() - 56;
        $('.mainContainer').css('height', height + "px");
        
        height += 56;
        $('html').css('height', height);
      }
      
  });
  
  
  $("#toggleLogin").click(function() {
    if ($("#loginActive").val() == "1") {
      $("#loginActive").val("0");
      $("#loginModalTitle").html("Sign up");
      $("#loginSignupButton").html("Sign up");
      $("#toggleLogin").html("Login");
    } else {
      $("#loginActive").val("1");
      $("#loginModalTitle").html("Login");
      $("#loginSignupButton").html("Login");
      $("#toggleLogin").html("Sign up");
    }
  });
  
  $("#loginSignupButton").click(function() {
    $.ajax({
      type: "POST",
      url: "action.php?action=loginSignup",
      data: "email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(), 
      success: function(result) {
        if (result == "1") {
          window.location.assign("http://files-from-web-dev-course-2-com.stackstaging.com/webdev2/12-Twitter/");
        } else {
          $("#loginAlert").html(result).show();
        }
      }
    })
  });
  
  $(".toggleFollow").click(function() {
    
    var id = $(this).attr('data-userId');
    
    $.ajax({
      type: "POST",
      url: "action.php?action=toggleFollow",
      data: "user_id=" + $(this).attr('data-userId'), 
      success: function(result) {
        if (result == "1") {
          $("button[data-userId='" + id + "']").html('Follow');
        } else if (result == "2") {
          $("button[data-userId='" + id + "']").html('Unfollow');
        }
      }
    })
  });
  
  $("#postTweetButton").click(function() {
    $.ajax({
      type: "POST",
      url: "action.php?action=postTweet",
      data: "tweetContent=" + $("#tweetContent").val(), 
      success: function(result) {
        if (result == "1") {
          $("#tweetSuccess").show();
          $("#tweetFail").hide();
          setTimeout(function() {
            $("#newTweetButton").attr('data-shown', '0');
            $("html, body").animate({ scrollTop: 0 }, "10");
            let height = $(window).height() - 56;
            $('.mainContainer').css('height', height + "px");
            setTimeout(function() {
              document.location.reload();
            }, 500);
          }, 2000);
        } else if (result != "") {
          $("#tweetFail").html(result).show();
          $("#tweetSuccess").hide();
        }
      }
    })
  });
  
  $("#newTweetButton").click(function(e) {
    e.preventDefault();
    if ($(this).attr('data-shown') == '0') {
      $(this).attr('data-shown', '1');
      $("html").css('height', 'auto');
      $('.mainContainer').css('height', 'auto');
      
      $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
    } else {
      $(this).attr('data-shown', '0');
      $("html, body").animate({ scrollTop: 0 }, "10");
      $("html").css('height', '100vh');
      let height = $(window).height() - 56;
      $('.mainContainer').css('height', height + "px");
    }
  });
</script>


  </body>
</html>

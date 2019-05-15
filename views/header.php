<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    
    <link rel="stylesheet" href="views/styles.css">

    <title>Switter</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="http://files-from-web-dev-course-2-com.stackstaging.com/webdev2/12-Twitter/"><i class="fas fa-dove"></i> Switter</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php if (array_key_exists('id', $_SESSION)) {
            echo
            '<li class="nav-item">
              <a class="nav-link" href="?page=timeline">Your timeline</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=yourtweets">Your tweets</a>
            </li>';
          }?>
          <li class="nav-item">
            <a class="nav-link" href="?page=publicprofiles">Public profiles</a>
          </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
          <?php if (array_key_exists('id', $_SESSION)) {
            echo '<a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>';
          } else {
            echo '<button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#myModal">Login / Sign up</button>';
          } ?>
        </div>
      </div>
    </nav>
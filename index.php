<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("functions.php");

include("views/header.php");

if (array_key_exists('page', $_GET) && $_GET['page'] == 'timeline') {
  include("views/timeline.php");
} else if (array_key_exists('page', $_GET) && $_GET['page'] == 'yourtweets') {
  include("views/yourtweets.php");
} else if (array_key_exists('page', $_GET) && $_GET['page'] == 'search') {
  include("views/search.php");
} else if (array_key_exists('page', $_GET) && $_GET['page'] == 'publicprofiles') {
  include("views/public_profiles.php");
} else {
  include("views/home.php");
}

include("views/footer.php");


?>
<?php

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


session_start();

$request_token = array();
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    // Abort! Something is wrong.
    die("Error! Returned OAuth token didn't match");
}
$connection = new TwitterOAuth($_SESSION['CONSUMER_KEY'], $_SESSION['CONSUMER_SECRET'], $request_token['oauth_token'], $request_token['oauth_token_secret']);
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

?>


<!DOCTYPE html>
<html>
<head>
    <title>I Have Danced The OAuth Dance For You</title>

<link rel="icon" 
      type="image/png" 
      href="danceremoji.png" />

      <style type="text/css">

      .key
      {
      	padding-left: 1em;
      	font-family: monospace;
      }
        </style>
</head>
<body>


<h1><center>Dancing complete!</center></h1>

<p>Here are the magic strings allowing you to authenticate as <a href="http://twitter.com/<?php echo($access_token["screen_name"]) ?>"><?php echo($access_token["screen_name"]) ?></a></p>
<?php
echo("Consumer key: <span class=\"key\">" . $_SESSION['CONSUMER_KEY'] . "</span><br>");
echo("Consumer secret: <span class=\"key\">" . $_SESSION['CONSUMER_SECRET'] . "</span><br>");
echo("Access key: <span class=\"key\">" . $access_token["oauth_token"] . "</span><br>");
echo("Access secret: <span class=\"key\">" . $access_token["oauth_token_secret"] . "</span><br>");
?>
<br><p> And here they are in a JSON array </p>
<pre>

{
    consumer_key:         '<?php echo($_SESSION['CONSUMER_KEY']) ?>'
  , consumer_secret:      '<?php echo($_SESSION['CONSUMER_SECRET']) ?>'
  , access_token:         '<?php echo($access_token["oauth_token"]) ?>'
  , access_token_secret:  '<?php echo($access_token["oauth_token_secret"]) ?>'
}
</pre>

<br>
<p>Thank you for joining us on this magical journey through Twitter app authentication</p>

</body>
</html>


<?php



//destroy the session

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
?>


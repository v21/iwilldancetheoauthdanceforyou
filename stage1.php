<?php


require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

$_SESSION['CONSUMER_KEY'] = $_POST['CONSUMER_KEY'];
$_SESSION['CONSUMER_SECRET'] = $_POST['CONSUMER_SECRET'];
define('OAUTH_CALLBACK', "http://v21.io/iwilldancetheoauthdanceforyou/callback.php");

$connection = new TwitterOAuth($_SESSION['CONSUMER_KEY'], $_SESSION['CONSUMER_SECRET']);



$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

//redirect to $url

header('Location: ' . $url);
die();
?>
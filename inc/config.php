<?php

// show all the errors to help development
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// set website title
if ($_SERVER['REQUEST_METHOD'] == 'POST')
	$title = "Search results";
else
	$title = "Homepage";

// Google API key
$apikey_js = "google_javascript_api";
$apikey_web = "google_web_api";

?>

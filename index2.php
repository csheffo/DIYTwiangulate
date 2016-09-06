<!DOCTYPE html>
<head>
	<title>DIY Twiangulate Results Page </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>

<h1>This page will display the results of Twitter API calls</h1>
<div id="output"></div>

<?php

ini_set("display_errors", "On");

#authenticate API call using Abraham PHP library
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

//TODO: create secrets file
//TODO: a LOT more error checking

function getTwitterConnection() {
	# connect to Twitter using the provided library.
	# Returns: Twitter connection object
	$consumer_key = "GP7IkgquvX4prwlQuPm0QKVDc";
	$consumer_secret = "wcLpJZl5bqsVDPFym94FKcAAugrK9FfWWfv9hYtQavghXhxofJ";
	$access_token = "838555939-oVj5qKEc5Ke2sgqZ5mVMQnq2TSVFWRJoDE6GWZE8";
	$access_token_secret = "tsgfshSvYE3csChivPUN0qokkHoR9ED9THdaNFQp6ndgW";

	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

	return $connection;
}

function getFriends($conn, $uid) {
	# get the list of people that uid follows, using connection.
	# Returns: array from Twitter of friend objects. Format defined by API.
	$friends = [];
	$friends = $conn->get("friends/ids", ["screen_name" => $uid,count => 	5000]);
	if (property_exists($friends, "errors")){
		$message = "In getFriends: ";
		foreach ($friends->errors as $key=>$error){
			$message .= sprintf("<p>%s (ID: %d)</p>", $error->message, $error->code);
		}
		throw new TwitterOAuthException ($message);
	}
	return $friends;
}

function getProfile($conn, $data){
	# get a list of user profiles when provided an array of user_ids in $data.
	# Returns: array of profile objects from Twitter. Format defined by API.
	$profileResults = [];

	//TODO: check if you have an array, and if not, do this without the iterator
	foreach ($data as $key=>$value){
			$profile = $conn->get("users/lookup", ["user_id" => "$value"]);
			if (property_exists($profile, "errors")){
				$message = "In getProfile: ";
				foreach ($profile->errors as $key=>$error){
					$message .= sprintf("<p>%s (ID: %d)</p>", $error->message, $error->code);
				}
				throw new TwitterOAuthException ($message);
			}
			array_push($profileResults, $profile);
	}

	return $profileResults;
}

function GetScreenname ($profiles) {
	# debug function that dumps screennames from array of Twitter user objects
	# Returns: nothing
	foreach ($profiles as $key=>$value){
		#var_dump($value);
		foreach ($value as $item=>$i){
			var_dump($i->screen_name);
		} #end foreach element in object
	} #end foreach object in array
}

# BEGIN MAIN
try {
	# putting the accts to check in variables for now, so we can use forms later
	$acct1 = "mattboggie";
	$acct2 = "alexislloyd";

	$connection = getTwitterConnection();
	$list1 = getFriends($connection, $acct1);
	$list2 = getFriends($connection, $acct2);
	$complist = array_intersect($list1->ids, $list2->ids);

	# the array_slice here is used to pass a small list in during debugging
	# to prevent using up all our API calls in a short period
	$details = getProfile($connection, array_slice($complist, 0, 5));

	# TODO: Catherine, expand on the block below to show more details as you see fit!
	printf("<p>List of common friends between %s and %s:</p><ul>", $acct1, $acct2);
	foreach($details as $key=>$friend){
		printf("<li>%s</li>", $friend[0]->name);
	}
	print("<p>");

} catch (TwitterOAuthException $e){
	printf("Twitter call failed: %s</p>", $e->getMessage());
}


?>
</body>
</html>

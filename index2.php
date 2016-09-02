<!Doctype html>
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

define("CONSUMER_KEY", "GP7IkgquvX4prwlQuPm0QKVDc");

define("CONSUMER_SECRET", "wcLpJZl5bqsVDPFym94FKcAAugrK9FfWWfv9hYtQavghXhxofJ");

$access_token = "838555939-oVj5qKEc5Ke2sgqZ5mVMQnq2TSVFWRJoDE6GWZE8";

$access_token_secret = "tsgfshSvYE3csChivPUN0qokkHoR9ED9THdaNFQp6ndgW";

#Create call for 5000 of person 1's friends

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials"); #this gets my account info

$friends = [];

$friends = $connection->get("friends/ids", ["screen_name" => "sarahkliff",count => 	5000]);

#var_dump($friends); 

$friends2 = [];

$friends2 = $connection->get("friends/ids", ["screen_name" => "ddiamond", count=>5000]);

var_dump($friends2);

#declare a joined array that is the intersection of both friends lists

$joinedArray = array_intersect($friends->ids, $friends2->ids);

#Iterate through the joined array and print the account details by user id 

function OutputProfile ($data){
	$profileResults = [];

	$connection2 = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, 
	$access_token_secret);					        			
        	
		foreach ($data as $key=>$value){
		
			$content2 = $connection2->get("users/lookup", ["user_id" => "$value"]); 
			array_push($profileResults, $content2); 
	
		}
	return $profileResults; 
} 

$screenNames = array(); 

function GetScreenname ($profiles) {
	
	global $screenNames; 
	
	foreach ($profiles as $key=>$value){
	
		#var_dump($value); 
		foreach ($value as $item=>$i){
		
			var_dump($i->screen_name);
		}
	
	} 
	
}
	
	
	
	#foreach ($profiles as $key=>$value){
	
				#array_push($screenNames, $value->screen_name);
	
	#}
	
	#return $screenNames;
	

$results = OutputProfile($joinedArray);

#print_r($results); 

$names = GetScreenname($results); 

print_r($names); 

?>
</body>
</html> 


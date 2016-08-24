<!Doctype html>
<head>
	<title>DIY Twiangulate Results Page </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>

<h1>This page will display the results of Twitter API calls</h1>
<div id="output"></div> 

<?php

#set_include_path ("./lib");

#authenticate API call using Abraham PHP library

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

define("CONSUMER_KEY", "GP7IkgquvX4prwlQuPm0QKVDc");

define("CONSUMER_SECRET", "wcLpJZl5bqsVDPFym94FKcAAugrK9FfWWfv9hYtQavghXhxofJ");

$access_token = "838555939-oVj5qKEc5Ke2sgqZ5mVMQnq2TSVFWRJoDE6GWZE8";

$access_token_secret = "tsgfshSvYE3csChivPUN0qokkHoR9ED9THdaNFQp6ndgW";

#Create call for 5000 of person 1's friends

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, 						        $access_token_secret);
$content = $connection->get("account/verify_credentials"); #this gets my account info

$friends = [];

$friends = $connection->get("friends/ids", ["screen_name" => "mikeallen",count => 	5000]);

#print_r($content); uncommenting this prints my account details too 

#print_r($friends); 

$friends2 = [];

$friends2 = $connection->get("friends/ids", ["screen_name" => "samsteinhp", count=>5000]);

#print_r($content2); 

#print_r($friends2);

#declare a joined array that is the intersection of both friends lists

$joinedArray = array_intersect($friends->ids, $friends2->ids);

#print_r($joinedArray);

$newArray = $joinedArray; #maybe renaming this will make it an array in the function

print_r($newArray); 

#echo is_array($joinedArray); #testing to see if this is an array outside the function (1)

#Iterate through the joined array and print the account details by user id 

$results = []; 

function OutputProfile ($array){

	$tempArray = (array)newArray; 

	echo "You've made it into the function!<br>";
	
	echo is_array($tempArray);
        	
	foreach ($tempArray as $key=>$value){
	
		$results = (array)resultsFinal;
		
		$results = $connection->get("users/lookup");  
		array_push($resultsFinal, $value);
	
	}
	
}

OutputProfile($newArray);

print_r($resultsFinal); 

?>


</body>
</html> 


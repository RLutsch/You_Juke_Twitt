<html>
<head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php 
	require_once('TwitterAPIExchange.php');
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
 	$settings = array(
    'oauth_access_token' => "770973461728690177-1Xip2lk5fIzTkNci4OuwMtyyldCMeix",
    'oauth_access_token_secret' => "6I5jqHtEocJHTuMQRzeSzaJNNDsVtfYk3yWKTvqUSYexf",
    'consumer_key' => "K0v4N9SwMjVDmbxcuF97WPZcy",
    'consumer_secret' => "CNkhoLBGzR5xXP5v4v4NXywjMXFWJS6xrOPq00XehdCgGyOYXk"
    );
//	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	$url = "https://api.twitter.com/1.1/search/tweets.json";
	$requestMethod = "GET";
	$getfield = '?q=#wethinkcode&count=20';
//	$twitter = new TwitterAPIExchange($settings);
//	$twitter->setGetfield($getfield)
//    ->buildOauth($url, $requestMethod)
//     ->performRequest();
//	$getfield = '?screen_name=lutschross&count=20';
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
    	->performRequest(),$assoc = TRUE);
	if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
    foreach($string as $items)
    {
        echo "Time and Date of Tweet: ".$items[0]['created_at']."<br />";
        echo "Tweet: ". $items[0]['text']."<br />";
        echo "Tweeted by: ". $items[0]['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br /><hr />";
        echo "Phone: ". $items[0]['entities']['hashtags'][1]['text']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
	echo "<pre>";
//    print_r(array_values($string));
    echo "</pre>";
    ?> 
</body>
</html>

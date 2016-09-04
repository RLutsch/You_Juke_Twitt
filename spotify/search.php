<?php

/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';

$htmlBody = <<<END
<form method="GET">
  <div>
    Search Term: <input type="text" id="q" name="q" value= $string[0]['text']>
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="25">
  </div>
  <input type="submit" value="Search">
</form>
END;

// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if (isset($_GET['q']) && isset($_GET['maxResults'])) {
  /*
   * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
   * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
   * Please ensure that you have enabled the YouTube Data API for your project.
   */

  $DEVELOPER_KEY = 'AIzaSyAY8q9Mve1eMsY-Fq3xtCDmbYNONogxI2s';

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  $htmlBody = '';
  try {

    // Call the search.list method to retrieve results matching the specified
    // query term.
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $_GET['q'],
      'maxResults' => $_GET['maxResults'],
    ));

    $videos = '';
    $channels = '';
    $playlists = '';

    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    foreach ($searchResponse['items'] as $searchResult) {
      switch ($searchResult['id']['kind']) {
        case 'youtube#video':
          $videos .= sprintf('<li>%s </li>',
              $searchResult['id']['videoId']);
          break;
        case 'youtube#channel':
          $channels .= sprintf('<li>%s (%s)</li>',
              $searchResult['snippet']['title'], $searchResult['id']['channelId']);
          break;
        case 'youtube#playlist':
          $playlists .= sprintf('<li>%s (%s)</li>',
              $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
          break;
      }
    }
	
    $htmlBody .= <<<END
    <h3>Videos</h3>
    <ul>$videos</ul>
    <h3>Channels</h3>
    <ul>$channels</ul>
    <h3>Playlists</h3>
    <ul>$playlists</ul>
END;
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
echo "HALLO!!!!";
echo $searchResponse[1]['id']['videoId'];
?>
<!doctype html>
<html>
  <head>
    <title>YouTube Search</title>
  </head>
	<body>

<?php 
require_once('TwitterAPIExchange.php');
$settings = array('oauth_access_token' => "770973461728690177-1Xip2lk5fIzTkNci4OuwMtyyldCMeix",
'oauth_access_token_secret' => "6I5jqHtEocJHTuMQRzeSzaJNNDsVtfYk3yWKTvqUSYexf",
'consumer_key' => "K0v4N9SwMjVDmbxcuF97WPZcy",
'consumer_secret' => "CNkhoLBGzR5xXP5v4v4NXywjMXFWJS6xrOPq00XehdCgGyOYXk"
);
$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
$getfield = '?q=#wtc_request&count=20';
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
 ->buildOauth($url, $requestMethod)
 ->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, ther    e was a problem.</h3><p>Twitter returned the following error message    :</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
 foreach($string as $items)
 {
 	echo "Time and Date of Tweet: ".$items[0]['created_at']."<br />";
 	echo "Tweet: ". $items[0]['text']."<br />";
 	echo "Tweeted by: ". $items[0]['user']['name']."<br />";
 	echo "Screen name: ". $items['user']['screen_name']."<br /><hr />";
 echo "Phone: ". $items[0]['entities']['hashtags'][1]['text']."<br /    >";
 echo "Friends: ". $items['user']['friends_count']."<br />";
 echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
 }
?>
    <?=$htmlBody?>
	 <iframe width="420" height="315"
		src="https://www.youtube.com/embed/<?php echo $searchResponse[1]['id']['videoId'] ?>?autoplay=1">
	</iframe> 
	</body>
</html>

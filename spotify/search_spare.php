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
    Search Term: <input type="search" id="q" name="q" placeholder="Enter Search Term">
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
 11     require_once('TwitterAPIExchange.php');
 12     $settings = array(
 13     'oauth_access_token' => "770973461728690177-1Xip2lk5fIzTkNci4Ouw    MtyyldCMeix",
 14     'oauth_access_token_secret' => "6I5jqHtEocJHTuMQRzeSzaJNNDsVtfYk    3yWKTvqUSYexf",
 15     'consumer_key' => "K0v4N9SwMjVDmbxcuF97WPZcy",
 16     'consumer_secret' => "CNkhoLBGzR5xXP5v4v4NXywjMXFWJS6xrOPq00Xehd    CgGyOYXk"
 17     );
 18     $url = "https://api.twitter.com/1.1/search/tweets.json";
 19     $requestMethod = "GET";
 20     $getfield = '?q=#wethinkcode&count=20';
 21     $twitter = new TwitterAPIExchange($settings);
 22     $string = json_decode($twitter->setGetfield($getfield)
 23         ->buildOauth($url, $requestMethod)
 24         ->performRequest(),$assoc = TRUE);
 25     if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, ther    e was a problem.</h3><p>Twitter returned the following error message    :</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
 26     
 27     foreach($string as $items)
 28     {   
 29         echo "Tweet: ". $items[0]['text']."<br />";
 30     }
 31     ?>

    <?=$htmlBody?>
	 <iframe width="420" height="315"
		src="https://www.youtube.com/embed/<?php echo $searchResponse[1]['id']['videoId'] ?>?autoplay=1">
	</iframe> 
	</body>
</html>

<?php 

$twitterData = Post2Social_Twitter_Latest_Tweets::display_latest_tweets();

/*
echo '<pre>';
print_r( $twitterData );
echo '</pre>';
*/

/*
$url = home_url();
$get_url_prefix = Post2Social_Helper::get_url_parse($url, $part='scheme'); // https or http 

if (isset($twitterData->entities->media)) {
    foreach ($twitterData->entities->media as $media) {
		if ( $get_url_prefix == 'https' ) {
            echo $media_url = $media->media_url_https . '<br>'; // Or $media->media_url_https for the SSL version.
		} else {
			echo $media_url = $media->media_url . '<br>'; // Or $media->media_url_https for the SSL version.
		}
    }
}
*/

?>

    <div class="tweet-box">
          <h1>Latest Tweets</h1>
          <div class="tweets-widget">            
             <ul class="tweet-list">
                <?php if(!empty($twitterData)): foreach($twitterData as $tweet):
                        $latestTweet = $tweet->text;
                        $latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $latestTweet);
                        $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '<a class="tweet-author" href="http://twitter.com/$1" target="_blank">@$1</a>', $latestTweet);
                        $tweetTime = date("D M d H:i:s",strtotime($tweet->created_at));
                ?>
                <li class="tweet-wrapper">
                    <div class="tweet-thumb">
                      <span class="had-thumb"><a href="<?php echo $tweet->user->url; ?>" title="<?php echo $tweet->user->name; ?>"><img alt="" src="<?php echo $tweet->user->profile_image_url; ?>"></a></span>
                    </div>
                    <div class="tweet-content">
                        <h3 class="title" title="<?php echo $tweet->text; ?>"><?php echo $latestTweet; ?></h3>
                        <span class="meta"><?php echo $tweetTime; ?> - <span><span class="dsq-postid" rel="8286 http://www.techandall.com/?p=8286"><?php echo $tweet->favorite_count; ?> Favorite</span></span></span>
                    </div>
                </li>
                <?php endforeach; else: ?>
                <li class="tweet-wrapper">Tweets not found for the given username.</li>
                <?php endif; ?>
             </ul>
        </div>
    </div>
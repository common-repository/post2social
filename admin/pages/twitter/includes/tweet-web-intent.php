<?php
// source: https://dev.twitter.com/web/tweet-button/web-intent
// source: http://www.adweek.com/digital/using-twitter-web-intents-on-your-website/
$twitter_username = isset( $twitter_cards_options['twitter_username'] ) ? sanitize_text_field( $twitter_cards_options['twitter_username'] ) : '';

$http		 = $_SERVER['HTTPS'] = 'on' ? 'https://':'http://';
$url		 = urlencode( home_url() );
$text		 = urlencode('Hello world');
$hashtags 	 = "WordPress,plugins";  // comma separated list of hashtags (without #) to automatically be inserted into the tweet

?>

<a href="http://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $text; ?>&via=<?php echo $twitter_username; ?>&hashtags=<?php echo $hashtags; ?>">Tweet This</a>

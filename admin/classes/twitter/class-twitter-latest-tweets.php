<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_Twitter_Latest_Tweets 
{
	
	/**
	 * Display the latest tweets. 
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function display_latest_tweets() {
		
		$twitterData = ''; // def
		
		$cards_opt = get_option('cwp2s_twitter_cards_options');
		$auto_post_opt = get_option('cwp2s_twitter_auto_post_options');
		
		$twitter_username = isset( $cards_opt['twitter_username'] ) ? sanitize_text_field( $cards_opt['twitter_username'] ) : '';
		
		//Configuration
		$tweetNum = 10;
		
		$connection = Post2Social_Twitter::connect();
		
		if ( $connection ) {
		
			//Get user timeline feeds
			$twitterData = $connection->get(
			  'statuses/user_timeline',
			  array(
				  'screen_name'     => $twitter_username,
				  'count'           => $tweetNum,
				  'exclude_replies' => false
			  )
			);
		
		}
		
		return $twitterData;
		
	}
							
}

?>
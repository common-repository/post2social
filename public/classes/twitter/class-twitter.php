<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// #### Required #### Library that handles Twitter API
require_once( POST2SOCIAL_DIR . 'api/twitteroauth/autoload.php' );
use Abraham\TwitterOAuth\TwitterOAuth;

// Source: https://twitteroauth.com/

class Post2Social_Twitter
{
	
	/**
	 * Twitter connection.
	 *
	 * @since  1.0.0
	 * @return void $connection
	 */
    public static function connect() {
		$connection = ''; // def
		$error = ''; // def
		$auto_post_opt = get_option('cwp2s_twitter_auto_post_options');
		$twitter_api_key  = isset( $auto_post_opt['twitter_api_key'] ) ? sanitize_text_field( $auto_post_opt['twitter_api_key'] ) : '';
		$twitter_api_secret_key  = isset( $auto_post_opt['twitter_api_secret_key'] ) ? sanitize_text_field( $auto_post_opt['twitter_api_secret_key'] ) : '';
		$twitter_access_token  = isset( $auto_post_opt['twitter_access_token'] ) ? sanitize_text_field( $auto_post_opt['twitter_access_token'] ) : '';
		$twitter_access_token_secret  = isset( $auto_post_opt['twitter_access_token_secret'] ) ? sanitize_text_field( $auto_post_opt['twitter_access_token_secret'] ) : '';
		
		if ( !empty($twitter_api_key) || !empty($twitter_api_secret_key) || !empty($twitter_access_token) || !empty($twitter_access_token_secret) ) {
		
			$connection = new TwitterOAuth($twitter_api_key, 
										   $twitter_api_secret_key, 
										   $twitter_access_token,
										   $twitter_access_token_secret);
			
		} else {
			// missing required API keys
			$error = __('Missing required Twitter API keys.', 'post2social');
		}
		
		return $connection;
	}
	
	/**
	 * Twitter Tweet.
	 *
	 * @since  1.0.0
	 * @param object $tweet
	 * @return void  $response
	 */
    public static function tweet( $tweet ) {
		
		if ( empty( $tweet ) )
		return;
		
		global $wpdb;
		
		$response = ''; // def
		
		$tweet   = json_decode($tweet, true); // convert to array
		//$tweet_obj = json_decode($tweet); // convert to object
		
		$tweet_data = array(
			"title" 		=> $tweet['title'],
			"description"	=> $tweet['description'],
			"url"		    => $tweet['url'],
			"author"		=> $tweet['author']
		);

		$connection = Post2Social_Twitter::connect();
		
		if ( $connection ) {
			
			// process tweet
			#### Twitter Cards work by pulling metadata information straight from a posted link.
			#### You don't need <a /> tag to post link to Twitter.
			
			$twitter_tweet = $tweet['title'] . ' ' . $tweet['url'];
			
			$response = $connection->post('statuses/update', array('status' => $twitter_tweet));
			
		}
		
		return $response;
		
	}
	
	/**
	 * Twitter Tweet.
	 *
	 * @since  1.0.0
	 * @param string $tweet
	 * @return void  $response
	 */
    public static function text_tweet( $tweet ) {
		
		if ( empty( $tweet ) )
		return;
		
		global $wpdb;
		
		$response = ''; // def

		$connection = Post2Social_Twitter::connect();
		
		if ( $connection ) {
			
			// process tweet
			#### Twitter Cards work by pulling metadata information straight from a posted link.
			#### You don't need <a /> tag to post link to Twitter.
			
			$response = $connection->post('statuses/update', array('status' => $tweet));
			
		}
		
		return $response;
		
	}
	
	/**
	 * Twitter verify credentials.
	 *
	 * @since  1.0.0
	 * @return object $user
	 */
	public static function verify_credentials() {	
		
		global $wpdb;
		
		$connection = Post2Social_Twitter::connect();
		
		$user = ''; // def
		if ( $connection ) {
			
			// you can now call all the methods on the twitteroauth/connection object
			$user = $connection->get('account/verify_credentials');
		
		}
		return $user;
	   
	}
	
	/**
	 * Twitter get configuration.
	 *
	 * @since  1.0.0
	 * @return object $configuration
	 */
	public static function get_configuration() {	
		
		$connection = Post2Social_Twitter::connect();
		
		$configuration = ''; // def
		if ( $connection ) {
			
			// GET https://api.twitter.com/1.1/help/configuration.json
			$configuration = $connection->get("help/configuration", []);
		
		}
		return $configuration;
	   
	}
	
	
	
}

?>
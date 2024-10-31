<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// #### Required #### Library that handles Twitter API
//require_once( POST2SOCIAL_DIR . 'api/twitteroauth/autoload.php' );
//use Abraham\TwitterOAuth\TwitterOAuth;

class Post2Social_Twitter_Tweet
{
	
	/**
	 * Post tweet to Twitter. 
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function admin_post_tweet() {
		
		// get form data
		$formData = $_POST['formData'];
		
		// store validation results in array
		$validation = array();
		
		if ( empty( $formData ) )
		return;
		
		// parse string
		parse_str($formData, $postdata);
		
		// Add nonce for security and authentication.
		$nonce_action = 'cwp2s_twitter_tweet_box_form_nonce';
       
		// Check if a nonce is set.
		if ( ! isset( $postdata['cwp2s-twitter-tweet-box-form-nonce'] ) )
			return;
		// Check if a nonce is valid.
		if ( wp_verify_nonce( $postdata['cwp2s-twitter-tweet-box-form-nonce'], $nonce_action ) ) {
			
			$url      = isset( $postdata['twitter_tweet_url'] ) ? sanitize_text_field( $postdata['twitter_tweet_url'] ) : ''; // counted as 25 chars
			$message  = isset( $postdata['twitter_tweet_message'] ) ? wp_kses_post( $postdata['twitter_tweet_message'] ) : '';
			
			// make it safe
			$tweet = esc_attr( wp_strip_all_tags( stripslashes( trim($message) ), true ) ) . ' ' . $url;
			
			// tweet process
			$response = Post2Social_Twitter::text_tweet( $tweet );
			
			if ( $response ) {
				// success message
				$validation[] = __('Tweet posted. ', 'post2social');
				// validation
				echo Post2Social_Admin::displayAjaxFormsValidationResult($validation, $type='success');
			} else {
				// error message
				$validation[] = __('An unexpected error occurred while posting your tweet. Please try again.', 'post2social');
				// validation
				echo Post2Social_Admin::displayAjaxFormsValidationResult($validation, $type='error');
			}
			
		
		} else {
			// error message
			$validation[] = __('Nonce validation failed! ', 'post2social');
			// validation
			echo Post2Social_Admin::displayAjaxFormsValidationResult($validation, $type='error');
		}
		
		//echo json_encode(array('success'=>'', 'message'=>'' )); // return json	
		
        exit; // don't forget to exit!	
		
	}
							
}

?>
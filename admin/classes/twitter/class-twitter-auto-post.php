<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_Twitter_Auto_Post
{

	/**
	 * Twitter settings page Ajax process.
	 *
	 * @since  1.0.0
	 * @return 
	 */
    public function twitter_auto_post() 
	{
		// get form data
		$formData = $_POST['formData'];
		
		// store validation results in array
		$validation = array();
		
		if ( empty( $formData ) )
		return;
		
		// parse string
		parse_str($formData, $postdata);
		
		// Add nonce for security and authentication.
		$nonce_action = 'cwp2s_twitter_auto_post_form_nonce';
       
		// Check if a nonce is set.
		if ( ! isset( $postdata['cwp2s-twitter-auto-post-form-nonce'] ) )
			return;
		// Check if a nonce is valid.
		if ( wp_verify_nonce( $postdata['cwp2s-twitter-auto-post-form-nonce'], $nonce_action ) ) {
			
			$enable_twitter_auto_post  = isset( $postdata['enable_twitter_auto_post'] ) ? sanitize_text_field( $postdata['enable_twitter_auto_post'] ) : '';
			$twitter_account_name  = isset( $postdata['twitter_account_name'] ) ? sanitize_text_field( $postdata['twitter_account_name'] ) : '';
			$twitter_api_key  = isset( $postdata['twitter_api_key'] ) ? sanitize_text_field( $postdata['twitter_api_key'] ) : '';
			$twitter_api_secret_key  = isset( $postdata['twitter_api_secret_key'] ) ? sanitize_text_field( $postdata['twitter_api_secret_key'] ) : '';
			$twitter_access_token  = isset( $postdata['twitter_access_token'] ) ? sanitize_text_field( $postdata['twitter_access_token'] ) : '';
			$twitter_access_token_secret  = isset( $postdata['twitter_access_token_secret'] ) ? sanitize_text_field( $postdata['twitter_access_token_secret'] ) : '';
			
			$twitter_words_to_hashtags  = isset( $postdata['twitter_words_to_hashtags'] ) ? wp_kses_post( $postdata['twitter_words_to_hashtags'] ) : ''; // "wp_kses_post" Sanitize cont for allowed HTML tags. 
	
			$twitter_auto_post_options = get_option('cwp2s_twitter_auto_post_options');
			$version = $twitter_auto_post_options['version'];
			if( trim($version) == false ) $version = '';
	
			$arr = array(
				'version'                     => $version,
				'enable_twitter_auto_post'    => $enable_twitter_auto_post,
				'twitter_account_name'        => $twitter_account_name,
				'twitter_api_key'             => $twitter_api_key,
				'twitter_api_secret_key'      => $twitter_api_secret_key,
				'twitter_access_token'        => $twitter_access_token,
				'twitter_access_token_secret' => $twitter_access_token_secret,
				'twitter_words_to_hashtags'   => $twitter_words_to_hashtags // e.g. #post_title,#post_content,#post_excerpt,#post_link,#author_name
			);
	
			update_option('cwp2s_twitter_auto_post_options', $arr);
			
			// success message
			$validation[] = __('Settings has been updated. ', 'post2social');
			// validation
			echo Post2Social_Admin::displayAjaxFormsValidationResult($validation, $type='success');
		
		} else {
			// error message
			$validation[] = __('Form Validation failed!', 'post2social');
			// validation
			echo Post2Social_Admin::displayAjaxFormsValidationResult($validation, $type='error');
		}
		
		//echo json_encode(array('success'=>'', 'message'=>'' )); // return json	
		
        exit; // don't forget to exit!	
		
	}
				
}

?>
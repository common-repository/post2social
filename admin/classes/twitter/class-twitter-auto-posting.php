<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Twitter Auto post tweet when publish button clicked on admin posts, pages cpts view pages.
 */
	 
class Post2Social_Twitter_Auto_Posting
{

	/**
	 * Display admin notice upon on tweets.
	 *
	 * @since      1.0.0
     * @return     void $notice
	 */
	public function tweet_auto_posting_admin_notice()
	{ 
		if ( ! current_user_can( 'activate_plugins' ) )
			return;
	
	    $notice = ''; // def
		// If transient exist
		if ( get_transient( 'cwp2s_tweet_auto_posting_result' ) ) {
			
		  $tweet_button = '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://codeweby.com" data-text="Post2Social is the best all-in-one #WordPress #Twitter #plugin that will help you to keep your visitors flow high." data-via="codeweby">Tweet</a>';
			
		  $notice = '<div class="updated notice notice-success is-dismissible" id="message"><p>' 
		  . __('Tweet successfully posted.', 'post2social') . '</p>' 
		  . '<p>' . __('Share your Love by Tweeting to us: &nbsp; &nbsp; ', 'post2social') . $tweet_button . '</p>'  
		  . '</div>';
			// delete transient
			delete_transient( 'cwp2s_tweet_auto_posting_result' );	
			
			?>
            
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            
            <?php
		} 
		echo $notice; // use echo instead of return!!!
		
	}

	/**
	 * Process Twitter tweet auto publish.
	 * ###### This is for Twitter Auto Publisher Add-On. ######
	 *
	 * @since 1.0.0
	 * @access public static
	 * @param object $twitter_data
	 * @return void $response
	 */
	public static function process_twitter_auto_publish( $twitter_data ) 
	{	
		if ( empty( $twitter_data ) )
		return;
		
		$data_arr   = json_decode($twitter_data, true); // convert to array
		//$data_obj = json_decode($twitter_data); // convert to object
		
		$twitterdata = array(
			'post_id'              => $data_arr['post_id'],
			'twitter_auto_posting' => $data_arr['twitter_auto_posting'] // 1 or empty 
		);
		
		$post_id = $data_arr['post_id'];
		
		// only process if auto posting enabled
		if ( $data_arr['twitter_auto_posting'] != '1'  )
		return;
		
		$title       = Post2Social_Twitter_Auto_Posting::get_post_title( $post_id );
		$description = Post2Social_Twitter_Auto_Posting::create_post_description( $post_id );
		$url         = Post2Social_Twitter_Auto_Posting::get_post_url( $post_id );
		$author      = Post2Social_Twitter_Auto_Posting::get_post_author( $post_id );
		
		// replace words with defined hashtags
		$title       = Post2Social_Twitter_Auto_Posting::words_to_hashtags( $title );
		$description = Post2Social_Twitter_Auto_Posting::words_to_hashtags( $description );
		
		$tweet = array(
			"title" 		=> $title,
			"description"	=> $description,
			"url"		    => $url,
			"author"		=> '@'.$author
		);
		
		$tweet = json_encode($tweet); // json encode before send
		
		$response = Post2Social_Twitter::tweet( $tweet ); // process tweet
		
		return $response;

	}
	
	/**
	 * Process Twitter tweet auto posting.
	 * Using The do action: "cwp2s_process_twitter_auto_posting" 
	 *
	 * @since 1.0.0
	 * @param object $twitter_data
	 * @return void
	 */
	public function process_twitter_auto_posting( $twitter_data ) 
	{	
		if ( empty( $twitter_data ) )
		return;
		
		$data_arr   = json_decode($twitter_data, true); // convert to array
		//$data_obj = json_decode($twitter_data); // convert to object
		
		$twitterdata = array(
			'post_id'              => $data_arr['post_id'],
			'auto_post'            => $data_arr['auto_post'], // 1 or empty 
			'twitter_auto_posting' => $data_arr['twitter_auto_posting'], // 1 or empty 
			'twitter_card_type'    => $data_arr['twitter_card_type']
		);
		
		$post_id = $data_arr['post_id'];
		
		// only process if auto posting enabled
		if ( $data_arr['twitter_auto_posting'] != '1'  )
		return;
		
		$title       = Post2Social_Twitter_Auto_Posting::get_post_title( $post_id );
		$description = Post2Social_Twitter_Auto_Posting::create_post_description( $post_id );
		$url         = Post2Social_Twitter_Auto_Posting::get_post_url( $post_id );
		$author      = Post2Social_Twitter_Auto_Posting::get_post_author( $post_id );
		
		// replace words with defined hashtags
		$title       = Post2Social_Twitter_Auto_Posting::words_to_hashtags( $title );
		$description = Post2Social_Twitter_Auto_Posting::words_to_hashtags( $description );
		
		$tweet = array(
			"title" 		=> $title,
			"description"	=> $description,
			"url"		    => $url,
			"author"		=> '@'.$author
		);
		
		$tweet = json_encode($tweet); // json encode before send
		
		$response = Post2Social_Twitter::tweet( $tweet ); // process tweet
		
		if ( !empty($response) ) {
			// success, show admin notice using transient
			set_transient( 'cwp2s_tweet_auto_posting_result', true, 180 ); // for 180 seconds
		}
		
		return $response;
		
		/*
		echo '<pre>';
		print_r( $tweet );
		echo '</pre>';
		
		echo '<pre>';
		print_r( $twitterdata );
		echo '</pre>';
		exit;
		*/

	}
	
	/**
	 * Get post title.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param int $post_id
	 * @return string $post_title
	 */
    public static function get_post_title( $post_id ) {
		
		if ( empty( $post_id ) )
		return;
		
		$post_title = ''; // def
		// twitter post title max 70 chars
		$post = get_post($post_id); // post data object
		$post_title = $post->post_title;
		$post_title = Post2Social_Helper::shorten_text($text=$post_title, $limit='65'); // limit title
		$post_title = trim($post_title);
		return $post_title;
	}

	/**
	 * Create post description from post content.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param int $post_id
	 * @return string $description
	 */
    public static function create_post_description( $post_id ) {
		
		if ( empty( $post_id ) )
		return;
		
		$description = ''; // def
		// twitter description max 140 chars
		$post = get_post($post_id); // post data object
		$description = $post->post_content;
		$description = Post2Social_Helper::shorten_text($text=$description, $limit='75'); // limit title
		$description = esc_attr( wp_strip_all_tags( stripslashes( trim($description) ), true ) );
		return $description;
	}

	/**
	 * Get post url.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param int $post_id
	 * @return string $post_url
	 */
    public static function get_post_url( $post_id ) {
		
		if ( empty( $post_id ) )
		return;
		
		$post_url = ''; // def
		$post_url = get_permalink( $post_id );
		$post_url = esc_attr( wp_strip_all_tags( stripslashes( trim($post_url) ), true ) );
		return $post_url;
	}


	/**
	 * Get post author.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param int $post_id
	 * @return string $author
	 */
    public static function get_post_author( $post_id ) {
		
		if ( empty( $post_id ) )
		return;
		
		$author = ''; // def
		// twitter post title max 70 chars
		$post = get_post($post_id); // post data object
		$post_author_id = $post->post_author;
		// get user info
		$user_info     = get_userdata($post_author_id);
		$display_name  = $user_info->display_name;
		
		$author = trim($display_name);
		return $author;
	}
	
	/**
	 * Replace words in text.
	 *
	 * @since  1.0.0
	 * @access public static
	 * @param string $text
	 * @return string $text
	 */
    public static function words_to_hashtags( $text ) {
		
		if ( empty( $text ) )
		return;
		
		$twitter_auto_post_options = get_option('cwp2s_twitter_auto_post_options');
		$words  = isset( $twitter_auto_post_options['twitter_words_to_hashtags'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_words_to_hashtags'] ) : '';
		
		$words = str_replace(" ","",$words); // replace white spaces
		$words_array = explode(',', $words); // create array, explode by comma
		foreach($words_array as $word) {
           //echo $word . '<br>';
		   $text = str_replace($word,' #' . $word . '',$text);
		}
		
		return $text;
		
	}
		
						
}

?>
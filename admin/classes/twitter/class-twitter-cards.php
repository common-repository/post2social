<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_Twitter_Cards
{

	/**
	 * Twitter cards meta data.
	 *
	 * @since  1.0.0
	 * @return void
	 */
    public static function add_twitter_cards_meta_data() {
		
		// defaults
		$card           = '';
		$site           = '';
		$creator        = '';
		$url            = '';
		$title          = '';
		$description    = '';
		$image          = '';
		$plugin_version = '';
		
		$general_options = get_option('cwp2s_general_settings_options');

		$homepage_image_url        = isset( $general_options['homepage_image_url'] ) ? sanitize_text_field( $general_options['homepage_image_url'] ) : '';
		$homepage_description      = isset( $general_options['homepage_description'] ) ? wp_kses_post( $general_options['homepage_description'] ) : '';// wp kses post
		
		$default_image_url         = isset( $general_options['default_image_url'] ) ? sanitize_text_field( $general_options['default_image_url'] ) : '';
		$default_description       = isset( $general_options['default_description'] ) ? wp_kses_post( $general_options['default_description'] ) : '';// wp kses post
		
		$default_image_type        = isset( $general_options['default_image_type'] ) ? sanitize_text_field( $general_options['default_image_type'] ) : '';
		$image_custom_field_name   = isset( $general_options['image_custom_field_name'] ) ? sanitize_text_field( $general_options['image_custom_field_name'] ) : '';
		
		$cards_opt = get_option('cwp2s_twitter_cards_options');
		
		$enable_twitter_cards      = isset( $cards_opt['enable_twitter_cards'] ) ? sanitize_text_field( $cards_opt['enable_twitter_cards'] ) : '';
		$twitter_username          = isset( $cards_opt['twitter_username'] ) ? sanitize_text_field( $cards_opt['twitter_username'] ) : '';
		$twitter_card_type         = isset( $cards_opt['twitter_card_type'] ) ? sanitize_text_field( $cards_opt['twitter_card_type'] ) : 'summary'; // set default
		
		$include_meta_title        = isset( $cards_opt['include_meta_title'] ) ? sanitize_text_field( $cards_opt['include_meta_title'] ) : '';
		$include_meta_description  = isset( $cards_opt['include_meta_description'] ) ? sanitize_text_field( $cards_opt['include_meta_description'] ) : '';
		$include_meta_url          = isset( $cards_opt['include_meta_url'] ) ? sanitize_text_field( $cards_opt['include_meta_url'] ) : '';
		$include_meta_image        = isset( $cards_opt['include_meta_image'] ) ? sanitize_text_field( $cards_opt['include_meta_image'] ) : '';
		$include_meta_creator      = isset( $cards_opt['include_meta_creator'] ) ? sanitize_text_field( $cards_opt['include_meta_creator'] ) : '';
		$include_meta_site         = isset( $cards_opt['include_meta_site'] ) ? sanitize_text_field( $cards_opt['include_meta_site'] ) : '';
		
		// if twitter cards not enabled
		if ( $enable_twitter_cards != '1' )
		return;
		
		$plugin_data    = get_plugin_data( POST2SOCIAL_PLUGIN_FILE );
		$plugin_version = $plugin_data['Version'];
		
		$data_arr = array(
			'enable_twitter_cards'     => $enable_twitter_cards,
			'twitter_username'         => $twitter_username,
			'twitter_card_type'        => $twitter_card_type,
			'homepage_image_url'       => $homepage_image_url,
			'homepage_description'     => $homepage_description,
			'default_image_url'        => $default_image_url,
			'default_description'      => $default_description,
			'default_image_type'       => $default_image_type, // featured_image, content_first_image, custom_field
			'image_custom_field_name'  => $image_custom_field_name,
			'include_meta_title'       => $include_meta_title,
			'include_meta_description' => $include_meta_description,
			'include_meta_url'         => $include_meta_url,
			'include_meta_image'       => $include_meta_image,
			'include_meta_creator'     => $include_meta_creator, 
			'include_meta_site'        => $include_meta_site,
			'plugin_version'           => $plugin_version
		);
		
		// meta default
        $meta = array(
			"creator"	               => $creator,
			"url"		               => $url,
			"title"		               => $title,
			"description"              => $description, 
			"image"		               => $image
		);
		
        if( is_home() && is_front_page() ) {
			$meta = Post2Social_Twitter_Cards::is_homepage( $data_arr );
		} 
		// is_singular returns true: is_single(), is_page() or is_attachment()
		elseif ( is_singular() ) {
			$meta = Post2Social_Twitter_Cards::is_singular( $data_arr );
		} elseif ( is_category() || is_tax() || is_tag() ) {
			$meta = Post2Social_Twitter_Cards::is_category_or_tax_or_tag( $data_arr );
		} elseif ( is_search() ) {
			$meta = Post2Social_Twitter_Cards::is_search( $data_arr );
		}
		
		$cards_meta = array_merge( $data_arr, $meta );
		
		/*
		echo '<pre>';
		print_r( $cards_meta );
		echo '</pre>';
		exit;
		*/
		
		// display cards in source codes
		Post2Social_Twitter_Cards::twitter_cards_meta( $cards_meta );
		
	}
	
	/**
	 * Twitter cards on homepage.
	 *
	 * @since  1.0.0
	 * @param array $data_arr
	 * @return array $meta
	 */
    public static function is_homepage( $data_arr ) {
		
		if ( empty( $data_arr ) )
		return;
		
		$bloginfo_name = get_bloginfo('name'); // site title
		$bloginfo_name_creator = str_replace(" ","_",$bloginfo_name); // replace white spaces
		$bloginfo_desc = get_bloginfo('description'); // tagline
		
		$homepage_image_url    = isset( $data_arr['homepage_image_url'] ) ? sanitize_text_field( $data_arr['homepage_image_url'] ) : '';
		$homepage_description  = isset( $data_arr['homepage_description'] ) ? wp_kses_post( $data_arr['homepage_description'] ) : '';// Sanitize cont for allowed HTML tags.
		
		if ( !empty($homepage_description) ) {
			$homepage_description = $homepage_description;
		} else {
			$homepage_description = $bloginfo_desc;
		}
		
        return $meta = array(
			"creator"	    => trim($bloginfo_name_creator), // author
			"url"		    => home_url(),
			"title"		    => $bloginfo_name,
			"description"   => $homepage_description, 
			"image"		    => $homepage_image_url
		);
	}
	
	/**
	 * Twitter cards on pages, single posts and attachments.
	 *
	 * @since  1.0.0
	 * @param array $data_arr
	 * @return array $meta
	 */
    public static function is_singular( $data_arr ) {
		
		if ( empty( $data_arr ) )
		return;
		
		global $post;
		
		$post_id        = $post->ID;
	    $post_author_id = $post->post_author;
		$post_title     = $post->post_title;
		$post_content   = $post->post_content;
		$url            = get_permalink( $post_id );
		$current_url    = Post2Social_Helper::get_current_page_url();
		
		// get user info
		$user_info     = get_userdata($post_author_id);
		$display_name  = $user_info->display_name;
		$display_name  = str_replace(" ","_",$display_name); // replace white spaces
		
		$image = Post2Social_Twitter_Cards::image( $data_arr );
		
        return $meta = array(
			"creator"	    => trim($display_name), // author
			"url"		    => $url,
			"title"		    => $post_title,
			"description"   => $post_content, 
			"image"		    => $image
		);
		
	}
	
	/**
	 * Twitter cards on category, taxonomy and tags pages.
	 *
	 * @since  1.0.0
	 * @param array $data_arr
	 * @return array $meta
	 */
    public static function is_category_or_tax_or_tag( $data_arr ) {
		
		if ( empty( $data_arr ) )
		return;
		
		// def
		$title = '';
		$description = '';
		
		$bloginfo_name = get_bloginfo('name'); // site title
		$bloginfo_name = str_replace(" ","_",$bloginfo_name); // replace white spaces
		
		$current_url    = Post2Social_Helper::get_current_page_url();
	
		// get queried object
		$queried_obj   = get_queried_object();
		
		if ( $queried_obj->name ) {
			$title = $queried_obj->name; // taxonomy cat name
		}
		
		// desc, limit to max 140 char
		if ( $queried_obj->description ) {
			$description = $queried_obj->description; // taxonomy cat desc
		}
		
		$default_image_url    = isset( $data_arr['default_image_url'] ) ? sanitize_text_field( $data_arr['default_image_url'] ) : '';
		$default_description  = isset( $data_arr['default_description'] ) ? wp_kses_post( $data_arr['default_description'] ) : '';// Sanitize cont for allowed HTML tags.
		
		if ( empty($description) ) {
			$description = $default_description;
		}
		
        return $meta = array(
			"creator"	    => trim($bloginfo_name), // author
			"url"		    => trim($current_url),
			"title"		    => $title,
			"description"   => $description, 
			"image"		    => $default_image_url
		);
	}
	
	/**
	 * Twitter cards on search page.
	 *
	 * @since  1.0.0
	 * @param array $data_arr
	 * @return array $meta
	 */
    public static function is_search( $data_arr ) {
		
		if ( empty( $data_arr ) )
		return;
		
		$title  = esc_attr( wp_strip_all_tags( stripslashes( __('Search for', 'post2social').' "' . stripslashes( get_search_query() ) . '"' ), true ) );
		$url    = get_search_link();
		$bloginfo_name = get_bloginfo('name'); // site title
		$bloginfo_name = str_replace(" ","_",$bloginfo_name); // replace white spaces
		
		$default_image_url    = isset( $data_arr['default_image_url'] ) ? sanitize_text_field( $data_arr['default_image_url'] ) : '';
		$default_description  = isset( $data_arr['default_description'] ) ? wp_kses_post( $data_arr['default_description'] ) : ''; // Sanitize cont for allowed HTML tags.
		
		return $meta = array(
			"creator"	    => trim($bloginfo_name), // author
			"url"		    => $url,
			"title"		    => $title,
			"description"   => $default_description, 
			"image"		    => $default_image_url
		);
		
	}
	
	/**
	 * Twitter cards image option.
	 * Image Types: featured_image, content_first_image, custom_field
	 *
	 * @since  1.0.0
	 * @param array $data_arr
	 * @return string $image
	 */
    public static function image( $data_arr ) {
		
		if ( empty( $data_arr ) )
		return;
		
		global $post;
		$post_id = $post->ID;
		
		// def
		$img = '';
		$image   = '';
		
		$default_image_type       = isset( $data_arr['default_image_type'] ) ? sanitize_text_field( $data_arr['default_image_type'] ) : '';
		$image_custom_field_name   = isset( $data_arr['image_custom_field_name'] ) ? sanitize_text_field( $data_arr['image_custom_field_name'] ) : '';
		
		if ( $default_image_type == 'featured_image' ) {
			
			if ( has_post_thumbnail( $post_id ) ) { // check if the post has a Post Thumbnail assigned to it.
				//the_post_thumbnail_url( array(100, 100) );  // Other resolutions
				$image_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );  // full, medium, large, thumbnail
				$image = $image_arr[0];
			}
		} elseif ( $default_image_type == 'content_first_image' ) {
			
			$post_content   = $post->post_content;
			// get first image from string
			preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post_content, $img);
			if ( !empty($img) ) {
			   $image = $img[1]; // http://localhost/1.png
			}
			
		} elseif ( $default_image_type == 'custom_field' ) {
			if ( !empty($image_custom_field_name) ) {
				$image = get_post_meta($post_id, $image_custom_field_name , true);
			}
		}
		
		return $image;
		
	}
	
	/**
	 * Twitter cards meta.
	 *
	 * @since  1.0.0
	 * @param array $cards_meta
	 * @return void 
	 */
    public static function twitter_cards_meta( $cards_meta ) {
		
		if ( empty( $cards_meta ) )
		return;
		
		global $post;
		
		if ( isset($post->ID) ) {
			$post_id = $post->ID;
		    $twitter_card_type = get_post_meta($post_id,'_cwp2s_twitter_card_type', true); // custom setting for single page (class-twitter-metaboxes.php)
			if ( empty($twitter_card_type) ) {
				$twitter_card_type = $cards_meta['twitter_card_type']; // def
			}
		} else {
			$twitter_card_type = $cards_meta['twitter_card_type'];
		}
		
		$post_title = Post2Social_Helper::shorten_text($text=$cards_meta['title'], $limit='65'); // limit title
		$post_title = stripslashes( trim($post_title) );
		
		$description = Post2Social_Helper::shorten_text($text=$cards_meta['description'], $limit='75'); // limit title
		$description = wp_strip_all_tags( stripslashes( trim($description) ), true );
		
		$lb = "\n"; // use "" this will output the code line by line
        
		$output = '';
		$output .= '<!-- Post2Social Twitter Cards Meta Version: '.$cards_meta['plugin_version'].' -->' . $lb;
		$output .= ' <meta name="twitter:card" content="'. trim(esc_attr( $twitter_card_type )) . '"/> ' . $lb;
		// twitter publisher is the twitter username
		if ( $cards_meta['include_meta_site'] == '1' ) {
		    $output .= ' <meta name="twitter:site" content="@'. trim(esc_attr( $cards_meta['twitter_username'] )) . '"/> ' . $lb;
		}
		// twitter creator is the Post/Page Author 
		if ( $cards_meta['include_meta_creator'] == '1' ) {
		    $output .= ' <meta name="twitter:creator" content="@'. trim(esc_attr( $cards_meta['creator'] )) . '"/> ' . $lb; // author
		}
		// twitter url
		if ( $cards_meta['include_meta_url'] == '1' ) {
			// property="og:url" or name="twitter:url"
		    $output .= ' <meta name="twitter:url" content="'. trim(esc_url( wp_strip_all_tags( stripslashes( $cards_meta['url'] ) ) ) ). '"/> ' . $lb;
		}
		// twitter title
		if ( $cards_meta['include_meta_title'] == '1' ) {
			// property="og:title" or name="twitter:title"
		    $output .= ' <meta name="twitter:title" content="'. esc_attr( $post_title ) . '"/> ' . $lb;
		}	
		// twitter desc
		if ( $cards_meta['include_meta_description'] == '1' ) {
			// property="og:description" or name="twitter:description"
		    $output .= ' <meta name="twitter:description" content="'. esc_attr( $description ) . '"/> ' . $lb;
		}
		// twitter image
		if ( $cards_meta['include_meta_image'] == '1' ) {
			// property="og:image" or name="twitter:image"
		    $output .= ' <meta name="twitter:image" content="'. trim( esc_url( wp_strip_all_tags( stripslashes( $cards_meta['image'] ) ) ) ) . '"/> ' . $lb;
		}
		
		$output .= '<!-- Post2Social Twitter Cards Meta Author: www.codeweby.com -->' . $lb;
		
		echo apply_filters('add_twitter_cards_meta_data_filter', $output);
	}
	
	/**
	 * Twitter card types.
	 *
	 * @since  1.0.0
	 * @return array $card_types
	 */
    public static function get_twitter_card_types() {
		$card_types = array(
		//'plain_text'          => __( 'Plain Text', 'post2social' ),
		'summary'             => __( 'Summary Card', 'post2social' ),
		'summary_large_image' => __( 'Summary Card with Large Image', 'post2social' ),
		//'player'              => __( 'Player Card', 'post2social' ),
		);
		return apply_filters( 'cwp2s_twitter_card_types', $card_types ); // <- extensible
	}
	
	/**
	 * Twitter cards settings page Ajax process.
	 *
	 * @since  1.0.0
	 * @return 
	 */
    public function admin_twitter_cards_settings() {
		// get form data
		$formData = $_POST['formData'];
		
		// store validation results in array
		$validation = array();
		
		if ( empty( $formData ) )
		return;
		
		// parse string
		parse_str($formData, $postdata);
		
		// Add nonce for security and authentication.
		$nonce_action = 'cwp2s_twitter_cards_form_nonce';
       
		// Check if a nonce is set.
		if ( ! isset( $postdata['cwp2s-twitter-cards-form-nonce'] ) )
			return;
		// Check if a nonce is valid.
		if ( wp_verify_nonce( $postdata['cwp2s-twitter-cards-form-nonce'], $nonce_action ) ) {
			
			$enable_twitter_cards  = isset( $postdata['enable_twitter_cards'] ) ? sanitize_text_field( $postdata['enable_twitter_cards'] ) : '';
			$twitter_username  = isset( $postdata['twitter_username'] ) ? sanitize_text_field( $postdata['twitter_username'] ) : '';
			$twitter_card_type  = isset( $postdata['twitter_card_type'] ) ? sanitize_text_field( $postdata['twitter_card_type'] ) : '';
			
			$include_meta_title  = isset( $postdata['include_meta_title'] ) ? sanitize_text_field( $postdata['include_meta_title'] ) : '';
			$include_meta_description  = isset( $postdata['include_meta_description'] ) ? sanitize_text_field( $postdata['include_meta_description'] ) : '';
			$include_meta_url  = isset( $postdata['include_meta_url'] ) ? sanitize_text_field( $postdata['include_meta_url'] ) : '';
			$include_meta_image  = isset( $postdata['include_meta_image'] ) ? sanitize_text_field( $postdata['include_meta_image'] ) : '';
			$include_meta_creator  = isset( $postdata['include_meta_creator'] ) ? sanitize_text_field( $postdata['include_meta_creator'] ) : '';
			$include_meta_site  = isset( $postdata['include_meta_site'] ) ? sanitize_text_field( $postdata['include_meta_site'] ) : '';
	
			$twitter_cards_options    = get_option('cwp2s_twitter_cards_options');
			$version = $twitter_cards_options['version'];
			if( trim($version) == false ) $version = '';
	
			$arr = array(
				'version'                  => $version,
				'enable_twitter_cards'     => $enable_twitter_cards,
				'twitter_username'         => $twitter_username,
				'twitter_card_type'        => $twitter_card_type,
				'include_meta_title'       => $include_meta_title,
				'include_meta_description' => $include_meta_description,
				'include_meta_url'         => $include_meta_url,
				'include_meta_image'       => $include_meta_image,
				'include_meta_creator'     => $include_meta_creator, // @...
				'include_meta_site'        => $include_meta_site // @...
			);
			
			/*
			echo '<pre>';
			print_r( $arr );
			echo '</pre>';
			exit;
			*/
	
			update_option('cwp2s_twitter_cards_options', $arr);
			
			// success message
			$validation[] = __('Twitter Cards Settings has been updated. ', 'post2social');
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
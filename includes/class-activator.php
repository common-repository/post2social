<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cataloggi 
 * @subpackage post2social/includes
 * @author     Attila Abraham
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 
 
class Post2Social_Activator {

	/**
	 * Install site settings.
	 *
	 * @since    1.0.0
	 */
	public static function install_single_site() 
	{
		Post2Social_Activator::general_settings_options();
		Post2Social_Activator::twitter_auto_post_options();
		Post2Social_Activator::twitter_cards_options();
		
		Post2Social_Activator::flush_rewrite_rules();
	}
	
	/**
	 * Twitter cards options.
	 *
	 * @since    1.0.0
	 */
	public static function general_settings_options() 
	{
		// check if option exist
		if ( get_option('cwp2s_general_settings_options') )
			return;

			$arr = apply_filters( 'cwp2s_general_settings_options_filter', array( // <- extensible  
				'version'                  => '1.0.0',
				'homepage_image_url'       => '',
				'homepage_description'     => '',
				'default_image_url'        => '',
				'default_description'      => '',
				'default_image_type'       => 'featured_image', // featured_image, content_first_image, custom_image
				'image_custom_field_name'  => '', // used if custom_image selected
				'share_on_social_metabox'  => '', // display metabox on posts, cpts and pages
			) );
	
			update_option('cwp2s_general_settings_options', $arr);
	}
	
	/**
	 * Twitter settings options.
	 *
	 * @since    1.0.0
	 */
	public static function twitter_auto_post_options() 
	{
		// check if option exist
		if ( get_option('cwp2s_twitter_auto_post_options') )
			return;

			$arr = apply_filters( 'cwp2s_twitter_auto_post_options_filter', array( // <- extensible 
				'version'                     => '1.0.0',
				'enable_twitter_auto_post'    => '1',
				'twitter_account_name'        => '',
				'twitter_api_key'             => '',
				'twitter_api_secret_key'      => '',
				'twitter_access_token'        => '',
				'twitter_access_token_secret' => '',
				'twitter_words_to_hashtags'   => 'word1 ,word2, word3', 
			) );
	
			update_option('cwp2s_twitter_auto_post_options', $arr);
	}
	
	/**
	 * Twitter cards options.
	 *
	 * @since    1.0.0
	 */
	public static function twitter_cards_options() 
	{
		// check if option exist
		if ( get_option('cwp2s_twitter_cards_options') )
			return;

			$arr = apply_filters( 'cwp2s_twitter_cards_options_filter', array( // <- extensible 
				'version'                  => '1.0.0',
				'enable_twitter_cards'     => '1',
				'twitter_username'         => '',
				'twitter_card_type'        => 'summary',
				'include_meta_title'       => '1',
				'include_meta_description' => '1',
				'include_meta_url'         => '1',
				'include_meta_image'       => '1',
				'include_meta_creator'     => '0', // @...
				'include_meta_site'        => '1', // @...
			) );
	
			update_option('cwp2s_twitter_cards_options', $arr);
	}
	
	/**
	 * This is how you would flush rewrite rules when a plugin is activated
	 *
	 * @since    1.0.0
	 */
	public static function flush_rewrite_rules() {
	    flush_rewrite_rules( false ); // soft flush. Default is true (hard), update rewrite rules
	}

}

?>

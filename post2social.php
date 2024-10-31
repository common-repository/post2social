<?php
/**
 * Plugin Name:     Post2Social
 * Description:     Bring more people from Twitter to your website. Grow your site traffic and increase online purchases. Included with Twitter Cards and Twitter Auto Post features.
 * Version:         1.0.3
 * Author:          Codeweby
 * Author URI:      https://codeweby.com/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     post2social
 *
 * @package         Post2Social
 * @author          Codeweby - Attila Abraham
 * @copyright       Copyright (c) Codeweby - Attila Abraham
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists( 'Post2Social' ) ) {
	
 class Post2Social {
	 
	/**
	 * @var         Post2Social $instance 
	 * @since       1.0.0
	 */
	private static $instance;
	
	/**
	 * Get active instance
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      object self::$instance
	 */
	public static function instance() {
		if( !self::$instance ) {
			self::$instance = new Post2Social();
			self::$instance->constants();
			self::$instance->includes();
			self::$instance->hooks();
			self::$instance->load_textdomain();
		}
		return self::$instance;
	}
	
	/**
	 * Plugin constants
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function constants() {
		// Plugin path
		define( 'POST2SOCIAL_DIR', plugin_dir_path( __FILE__ ) );
		// Plugin URL
		define( 'POST2SOCIAL_URL', plugin_dir_url( __FILE__ ) );
		// Plugin FILE
		define( 'POST2SOCIAL_PLUGIN_FILE', __FILE__ );
	}
	
	/**
	 * Include files
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function includes() {
		// Include scripts
		require_once POST2SOCIAL_DIR . 'admin/class-admin.php';
		require_once POST2SOCIAL_DIR . 'public/class-public.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/class-multisite.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/class-general.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/class-metaboxes.php';
		
		require_once POST2SOCIAL_DIR . 'admin/classes/twitter/class-twitter-auto-post.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/twitter/class-twitter-cards.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/twitter/class-twitter-auto-posting.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/twitter/class-twitter-latest-tweets.php';
		require_once POST2SOCIAL_DIR . 'admin/classes/twitter/class-twitter-tweet.php';
		// Third-parties
		//if( ! class_exists( 'TwitterOAuth' ) ) {
		    include_once POST2SOCIAL_DIR . 'api/twitteroauth/autoload.php';
		//}
		// Twitter Main Class
		require_once POST2SOCIAL_DIR . 'public/classes/twitter/class-twitter.php';
		require_once POST2SOCIAL_DIR . 'public/classes/class-helper.php';
	}
	
	/**
	 * Run action and filter hooks
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function hooks() {
		$plugin_admin         = new Post2Social_Admin();
	    $plugin_public        = new Post2Social_Public();
		$multisite            = new Post2Social_Multisite();
		$general              = new Post2Social_General();
		$metaboxes            = new Post2Social_Metaboxes();
		$twitter_auto_post    = new Post2Social_Twitter_Auto_Post();
		$twitter_cards        = new Post2Social_Twitter_Cards();
		$twitter_auto_posting = new Post2Social_Twitter_Auto_Posting();
		$latest_tweets        = new Post2Social_Twitter_Latest_Tweets();
		$twitter_tweet        = new Post2Social_Twitter_Tweet();
	    // add_action 'init', array( $this, 'class_method_name' ), 1 );
	    add_action( 'admin_menu', array($plugin_admin, 'admin_menu') );
	    // Multisite
	    add_action( 'wpmu_new_blog', array($multisite, 'multisite_new_site_activation'), 12, 6 );
		
		add_action( 'wp_ajax_admin_post_tweet', array($twitter_tweet, 'admin_post_tweet') );
		add_action( 'wp_ajax_nopriv_admin_post_tweet', array($twitter_tweet, 'admin_post_tweet') );
		
		add_action( 'wp_ajax_admin_general_settings', array($general, 'admin_general_settings') );
		add_action( 'wp_ajax_nopriv_admin_general_settings', array($general, 'admin_general_settings') );
		
		add_action( 'wp_ajax_twitter_auto_post', array($twitter_auto_post, 'twitter_auto_post') );
		add_action( 'wp_ajax_nopriv_twitter_auto_post', array($twitter_auto_post, 'twitter_auto_post') );
		
		add_action( 'wp_ajax_admin_twitter_cards_settings', array($twitter_cards, 'admin_twitter_cards_settings') );
		add_action( 'wp_ajax_nopriv_admin_twitter_cards_settings', array($twitter_cards, 'admin_twitter_cards_settings') );
		
		add_action( 'wp_head', array($twitter_cards, 'add_twitter_cards_meta_data'), 99999 );
		
		add_action( 'add_meta_boxes', array($metaboxes, 'add_metaboxes_share_on_social') );
		add_action( 'save_post', array($metaboxes, 'save_share_on_social'), 10, 2 );
		
		add_action( 'cwp2s_process_twitter_auto_posting', array($twitter_auto_posting, 'process_twitter_auto_posting'), 10, 1 ); // <- extended
		add_action( 'admin_notices', array($twitter_auto_posting, 'tweet_auto_posting_admin_notice') );
		
		add_action( 'admin_enqueue_scripts', array($plugin_admin, 'admin_enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array($plugin_admin, 'admin_enqueue_scripts') );
		
		add_action( 'wp_enqueue_scripts', array($plugin_public, 'public_enqueue_styles'), 15 ); // ### Important! Load style after theme style (15)
		add_action( 'wp_enqueue_scripts', array($plugin_public, 'public_enqueue_scripts') );
		
	}
	
	/**
	 * Internationalization
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function load_textdomain() {
		// language directory
		$lang_dir = POST2SOCIAL_DIR . '/languages/';
		
	}
	
 }
	
} // if class_exists end


/*
 * Load: Post2Social
 */
 
function Post2Social_Load() {

  // require plugin.php
  require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  
  // only load plugin if Cataloggi active
  // if( class_exists( 'Cataloggi' ) ) {
    return Post2Social::instance();
  // }
}
add_action( 'plugins_loaded', 'Post2Social_Load' );

/**
 * The code that runs during plugin activation.
 */
register_activation_hook( __FILE__, 'post2social_activation' ); 
function post2social_activation( $network_wide ) {
	
	global $wpdb;
	
    if ( ! current_user_can( 'activate_plugins' ) )
        return;

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	
	// Check if the plugin is being network-activated or not.
	if ( $network_wide ) {
		// Retrieve all site IDs from this network (WordPress >= 4.6 provides easy to use functions for that).
		if ( function_exists( 'get_sites' ) && function_exists( 'get_current_network_id' ) ) {
		  $site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );
		} else {
		  $site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
		}
		
		// Install the plugin for all these sites.
		foreach ( $site_ids as $site_id ) {
		  switch_to_blog( $site_id );
          Post2Social_Activator::install_single_site();
		  restore_current_blog();
		}
	} else {
        Post2Social_Activator::install_single_site();
	}
	
}

/**
 * The code that runs during plugin deactivation.
 */
register_deactivation_hook( __FILE__, 'post2social_deactivation' ); 
function post2social_deactivation( $network_wide ) {
	
	global $wpdb;
	
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
		
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';

	// Check if the plugin is being network-activated or not.
	if ( $network_wide ) {
		// Retrieve all site IDs from this network (WordPress >= 4.6 provides easy to use functions for that).
		if ( function_exists( 'get_sites' ) && function_exists( 'get_current_network_id' ) ) {
		  $site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );
		} else {
		  $site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
		}
		
		// Install the plugin for all these sites.
		foreach ( $site_ids as $site_id ) {
		  switch_to_blog( $site_id );
		  
			// DEACTIVATION
			Post2Social_Activator::flush_rewrite_rules();
			
		  restore_current_blog();
		}
	} else {
		// DEACTIVATION
		Post2Social_Activator::flush_rewrite_rules();
	}
	
}

/**
 * The code that runs during plugin uninstallation.
 */
register_uninstall_hook( __FILE__, 'post2social_uninstall' ); 
function post2social_uninstall() {
	
	global $wpdb;
	
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
		
	//this check makes sure that this file is called manually.
	if (!defined("WP_UNINSTALL_PLUGIN"))
		return;
	
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	
	// Check if we are on a Multisite or not.
	if ( is_multisite() ) {
		// Retrieve all site IDs from all networks (WordPress >= 4.6 provides easy to use functions for that).
		if ( function_exists( 'get_sites' ) ) {
		  $site_ids = get_sites( array( 'fields' => 'ids' ) );
		} else {
		  $site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs;" );
		}
		
		// Uninstall the plugin for all these sites.
		foreach ( $site_ids as $site_id ) {
		  switch_to_blog( $site_id );
		  
		  // UNINSTALLATION
		  Post2Social_Activator::flush_rewrite_rules();
			
		  restore_current_blog();
		}
	} else {
		// UNINSTALLATION
		Post2Social_Activator::flush_rewrite_rules();
	}
	
}


?>
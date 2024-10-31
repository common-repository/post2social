<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_Admin
{
	
	/**
	 * Admin notices.
	 */
	public $admin_notices;
	
    public function admin_menu() {
      add_menu_page ( 
		  $page_title = 'Post2Social',
		  $menu_title = 'Post2Social',
		  $capability = 'edit_pages', // admin, editor, user etc.
		  $menu_slug  = 'post2social',
		  $function   = array( $this, 'main_page'), 
		  $icon_url   = 'dashicons-admin-users', // dashicons-share https://developer.wordpress.org/resource/dashicons/#admin-users
		  //$icon_url   = POST2SOCIAL_URL( '/'),
		  $position   = '25.1' // after Comments
	  );
	}
	
	public function main_page() {
	   
	   // get options
	   $general_options = get_option('cwp2s_general_settings_options');
	   $twitter_auto_post_options = get_option('cwp2s_twitter_auto_post_options');
	   $twitter_cards_options    = get_option('cwp2s_twitter_cards_options');
	   require_once POST2SOCIAL_DIR . 'admin/pages/main.php'; // main page 
		
	}
	
	/**
	 * Main pages tabs.
	 *
	 * @since      1.0.0
     * @return     array   $tabs
	 */
    public static function main_pages_tabs() 
	{
		$tabs = array(
		'general'      => __( 'General', 'post2social' ), // general.php
		'twitter'      => __( 'Twitter', 'post2social' ), // twitter.php
		//'facebook-main'     => __( 'Facebook', 'post2social' ),
		//'googleplus-main'   => __( 'Google +', 'post2social' ),
		);
		return apply_filters( 'cwp2s_main_pages_tabs', $tabs ); // <- extensible
	}
	
	/**
	 * Sub pages tabs.
	 *
	 * @since      1.0.0
     * @return     array   $tabs
	 */
    public static function sub_pages_tabs($main) 
	{
		if ( empty( $main ) )
		return;
		
		if ( $main == 'twitter' ) {
			$tabs = array(
			'tweet'             => __( 'Tweet', 'post2social' ),
			'twitter-cards'     => __( 'Twitter Cards', 'post2social' ),
			'twitter-auto-post' => __( 'Twitter Auto Post', 'post2social' ), 
			);
			return apply_filters( 'cwp2s_twitter_sub_pages_tabs', $tabs ); // <- extensible
		} elseif ( $main == 'facebook' ) {
			$tabs = array(
			'facebook'          => __( 'Facebook', 'post2social' ),
			);
			return apply_filters( 'cwp2s_facebook_sub_pages_tabs', $tabs ); // <- extensible
		} elseif ( $main == 'googleplus' ) {
			$tabs = array(
            'google'            => __( 'Google', 'post2social' ),
			);
			return apply_filters( 'cwp2s_google_sub_pages_tabs', $tabs ); // <- extensible
		} elseif ( $main == 'general' ) {
			$tabs = array(
            'settings'          => __( 'General Settings', 'post2social' ), 
			);
			return apply_filters( 'cwp2s_general_sub_pages_tabs', $tabs ); // <- extensible
		}  elseif ( $main == 'auto-publish' ) {
			$tabs = array(
			'auto-publish'      => __( 'Auto Publish', 'post2social' ),
            'settings'          => __( 'Settings', 'post2social' ), 
			);
			return apply_filters( 'cwp2s_auto_publish_sub_pages_tabs', $tabs ); // <- extensible
		} else {
			return;
		}
		
	}
	
	/**
	 * Get registered post types.
	 *
	 * @since  1.0.0
	 * @return array $post_types
	 */
	public static function get_registered_post_types() {
		$post_types = get_post_types();
		unset($post_types['revision']);
		unset($post_types['attachment']);
		unset($post_types['nav_menu_item']);
		return $post_types;
	}
	
	/**
	 * Get registered taxonomies.
	 *
	 * @since  1.0.0
	 * @return array $taxonomies
	 */
	public static function get_registered_taxonomies() {
		$taxonomies = get_taxonomies();
		unset($taxonomies['nav_menu']);
		unset($taxonomies['post_format']);
		return $taxonomies;
	}
	
	/**
	 * Output admin Ajax notification messages.
	 *
	 * @since      1.0.0
     * @return     void
	 */
    public static function displayAjaxFormsValidationResult($validation='', $type='success') 
	{
		$output = '';
		
	    if ( $validation != '') {
		
			if ($type == 'success') {
				$type = 'alert-success'; // css
			} else if ($type == 'info') {
				$type = 'alert-info'; // css
			} else if ($type == 'error') {
				$type = 'alert-danger'; // css
			}
			
			// display validation error messages
			if( $validation != '' ) {
				$output .= '<div class="cw-form-msgs">';
				foreach ($validation as $validate ) {
				  $output .= '<div class="form-messages ' . $type . '">';
				  $output .= '&nbsp; ' . $validate; 
				  $output .= '</div>';
				}
				$output .= '</div>';
			}
			return $output;	
		
		} else {
			return false;
		}
	}
	
	// Enqueue Styles
	public function admin_enqueue_styles() {	
	    wp_enqueue_style( 'post2social-admin-css', POST2SOCIAL_URL . 'admin/assets/css/admin.css', array(), '', 'all' );
		wp_enqueue_style( 'post2social-admin-tweet-box-css', POST2SOCIAL_URL . 'admin/assets/css/tweet-box.css', array(), '', 'all' );
		// call from parent assets folder
		wp_enqueue_style( 'post2social-admin-cw-form', POST2SOCIAL_URL . 'assets/css/cw-form.css', array(), '', 'all' );
		// call from parent assets folder
		wp_enqueue_style( 'post2social-admin-glyphicon', POST2SOCIAL_URL . 'assets/css/glyphicon.css', array(), '', 'all' );
	}
	
	// Enqueue Scripts
	public function admin_enqueue_scripts() {	
	    wp_enqueue_script( 'post2social-admin-js', POST2SOCIAL_URL . 'admin/assets/js/admin.js', array( 'jquery' ), '', true ); 
		wp_enqueue_script( 'post2social-twitter-widgets', 'https://platform.twitter.com/widgets.js', array( 'jquery' ), '', true); // twitter
		
		//jQuery UI date picker file
		wp_enqueue_script('jquery-ui-datepicker');
		
	}
	
	
	
}

?>
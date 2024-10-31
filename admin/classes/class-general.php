<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_General
{
	
	/**
	 * Default image options. 
	 *
	 * @since  1.0.0
	 * @return array $image_options
	 */
    public static function default_image_options() {
		$image_options = array(
		'featured_image'      => __( 'Featured Image', 'post2social' ),
		'content_first_image' => __( 'Content First Image', 'post2social' ),
		'custom_field'        => __( 'From a Custom Field', 'post2social' ),
		);
		return apply_filters( 'cwp2s_default_image_options', $image_options ); // <- extensible
	}
	
	/**
	 * General settings page Ajax process.
	 *
	 * @since  1.0.0
	 * @return 
	 */
    public function admin_general_settings() {
		// get form data
		$formData = $_POST['formData'];
		
		// store validation results in array
		$validation = array();
		
		if ( empty( $formData ) )
		return;
		
		// parse string
		parse_str($formData, $postdata);
		
		// Add nonce for security and authentication.
		$nonce_action = 'cwp2s_general_settings_form_nonce';
       
		// Check if a nonce is set.
		if ( ! isset( $postdata['cwp2s-general-settings-form-nonce'] ) )
			return;
		// Check if a nonce is valid.
		if ( wp_verify_nonce( $postdata['cwp2s-general-settings-form-nonce'], $nonce_action ) ) {

			$homepage_image_url  = isset( $postdata['homepage_image_url'] ) ? sanitize_text_field( $postdata['homepage_image_url'] ) : '';
			$homepage_description  = isset( $postdata['homepage_description'] ) ? sanitize_text_field( $postdata['homepage_description'] ) : '';
			$default_image_url  = isset( $postdata['default_image_url'] ) ? sanitize_text_field( $postdata['default_image_url'] ) : '';
			$default_description  = isset( $postdata['default_description'] ) ? wp_kses_post( $postdata['default_description'] ) : '';// Sanitize cont for allowed HTML tags.
			$default_image_type  = isset( $postdata['default_image_type'] ) ? sanitize_text_field( $postdata['default_image_type'] ) : ''; // radio
			$image_custom_field_name  = isset( $postdata['image_custom_field_name'] ) ? sanitize_text_field( $postdata['image_custom_field_name'] ) : '';
			
			// Checkboxes
			if( isset( $postdata['share_on_social_metabox'] ) ) {
				$share_on_social_metabox = $postdata['share_on_social_metabox']; // post types
				$share_on_social_metabox = json_encode($share_on_social_metabox); // encode to json before save
				/*
				echo '<pre>';
				print_r( $share_on_social_metabox );
				echo '</pre>';
				exit;
				*/
				
			} else {
				$share_on_social_metabox = '';
			}
	
			$general_options = get_option('cwp2s_general_settings_options');
			$version = $general_options['version'];
			if( trim($version) == false ) $version = '';
	
			$arr = array(
				'version'                  => $version,
				'homepage_image_url'       => $homepage_image_url,
				'homepage_description'     => $homepage_description,
				'default_image_url'        => $default_image_url,
				'default_description'      => $default_description,
				'default_image_type'       => $default_image_type, // featured_image, content_first_image, custom_field
				'image_custom_field_name'  => $image_custom_field_name,
				'share_on_social_metabox'  => $share_on_social_metabox,
			);
			
			/*
			echo '<pre>';
			print_r( $arr );
			echo '</pre>';
			exit;
			*/
	
			update_option('cwp2s_general_settings_options', $arr);
			
			// success message
			$validation[] = __('General Settings has been updated. ', 'post2social');
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
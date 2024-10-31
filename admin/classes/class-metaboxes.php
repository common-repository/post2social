<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Post2Social_Metaboxes
{
	
	/**
	 * Add Metaboxes.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_metaboxes_share_on_social() {
		//$post_types = Post2Social_Admin::get_registered_post_types();
		$post_types  = ''; // def
		$general_options = get_option('cwp2s_general_settings_options');
		$twitter_auto_post_options = get_option('cwp2s_twitter_auto_post_options');
		// display the metavox on the saved post types only
		if ( isset( $general_options['share_on_social_metabox'] ) && !empty($general_options['share_on_social_metabox']) ) {
			$post_types  = $general_options['share_on_social_metabox'];
			$post_types  = json_decode($post_types, true); // convert to array
		}
		
		if ( !empty($post_types) ) {
			foreach ($post_types as $key => $value ) {
				add_meta_box(
					'cwp2s_share_on_social',
					__( '<strong>Post2Social</strong> - Share on Social', 'post2social' ), 
					array( $this, 'render_share_on_social' ), 
					$value, // post type
					'side',
					'high'
				);
			}
		}
	}
	
	/**
	 * Render Metaboxes.
	 *
	 * @since 1.0.0
	 * @param object $post
	 * @return void
	 */
	public function render_share_on_social( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'cwp2s_share_on_social_nonce_action', 'cwp2s_share_on_social_nonce' );
		
		// Get the meta for all keys for the current post
		$meta = get_post_meta( $post->ID );
		$post_id = $post->ID;
		
		$twitter_cards_options     = get_option('cwp2s_twitter_cards_options');
		$twitter_auto_post_options = get_option('cwp2s_twitter_auto_post_options');
		$enable_twitter_auto_post  = isset( $twitter_auto_post_options['enable_twitter_auto_post'] ) ? sanitize_text_field( $twitter_auto_post_options['enable_twitter_auto_post'] ) : '';	
		
		$twitter_card_type_default = isset( $twitter_cards_options['twitter_card_type'] ) ? sanitize_text_field( $twitter_cards_options['twitter_card_type'] ) : '';
		if ( $twitter_card_type_default == '' ) {
			$twitter_card_type_default = 'summary'; // def
		}
		
		$twitter_card_type = get_post_meta($post->ID,'_cwp2s_twitter_card_type', true);
		// only Open Graph no cards
		if ( $twitter_card_type == '' ) {
			$twitter_card_type = $twitter_card_type_default; // default
		}

		$auto_post = get_post_meta($post->ID,'_cwp2s_auto_post', true);
		if ( $auto_post == '' ) {
			$auto_post = ''; // default
		}
		
		$twitter_auto_posting = get_post_meta($post->ID,'_cwp2s_twitter_auto_posting', true);
		if ( $twitter_auto_posting == '' ) {
			$twitter_auto_posting = ''; // default
		}

		$info = '<span class="cwp2s-tooltip tooltip-info-icon" title="' . __( "The default Twitter Card format for this page.", 'post2social') . '"></span>';
		?>

		<div class="cw-twitter-cards">
		<span class="title"><?php _e( 'Twitter Cards', 'post2social' ); ?><?php echo $info; ?></span>
		<div class="cw-twitter-cards-box">
		
        <p><input name="cwp2s_twitter_card_type" id="cwp2s_twitter_card_type_summary" value="summary" <?php echo ($twitter_card_type == 'summary') ? 'checked' : ''; ?> type="radio"> <label for="cwp2s_twitter_card_type"><?php _e( 'Summary', 'post2social' ); ?> <span> <?php _e( '(Summary Card)', 'post2social' ); ?></span></label></p>
		
        <p style="margin-bottom:15px;"><input name="cwp2s_twitter_card_type" id="cwp2s_twitter_card_type_summary_large_image" value="summary_large_image" <?php echo ($twitter_card_type == 'summary_large_image') ? 'checked' : ''; ?> type="radio"> <label for="cwp2s_twitter_card_type"><?php _e( 'Summary Large', 'post2social' ); ?> <span> <?php _e('(With Large Image)', 'post2social' ); ?></span></label></p>
        
          <hr>
          
          <div class="checkbox margin-top-10 margin-bottom-15 title">
            <label for="cwp2s_auto_posting"><?php _e("Social Networks", 'post2social'); ?></label>
          </div>
            
          <div class="checkbox margin-bottom-15">   
            <input type="checkbox" value="1" <?php echo ($twitter_auto_posting == '1') ? 'checked' : ''; ?> id="cwp2s_twitter_auto_posting" name="cwp2s_twitter_auto_posting" />
            <span><?php _e("Twitter", 'post2social'); ?> </span>
          </div>

		  <?php 
             $facebook_auto_posting = '0';
          ?>          
          <div class="checkbox margin-bottom-15">   
            <input style="color: #999;" type="checkbox" value="1" <?php echo ($facebook_auto_posting == '1') ? 'checked' : ''; ?> id="cwp2s_facebook_auto_posting" name="cwp2s_facebook_auto_posting" disabled="disabled" />
            <span style="color: #999;"><?php _e("Facebook", 'post2social'); ?> </span>
          </div>
          
		  <?php 
             $googleplus_auto_posting = '0';
			 
			 $googleplus_enabled = '';
			 if ( $googleplus_enabled == '1' ) {
          ?>          
          <div class="checkbox margin-bottom-15">   
            <input style="color: #999;" type="checkbox" value="1" <?php echo ($googleplus_auto_posting == '1') ? 'checked' : ''; ?> id="cwp2s_googleplus_auto_posting" name="cwp2s_googleplus_auto_posting" disabled="disabled" />
            <span style="color: #999;"><?php _e("Google+", 'post2social'); ?> </span>
          </div>
          
          <?php 
			 }
			 
			 // ####### Add LinkedIn #######
		  ?>
          
          <hr>
          
          <div class="checkbox margin-top-10 margin-bottom-10">   
            <?php 
			// check if auto post checked: echo ($auto_post == '1') ? 'checked' : '';
			?>
            <input type="checkbox" value="1" id="cwp2s_auto_post" name="cwp2s_auto_post" />
            <span><?php _e("Auto Post", 'post2social'); ?> </span>
            <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Enable auto post for the above selected social networks. Page will be auto posted on the selected networks soon as you hit the publish button.", 'post2social'); ?>"></span>
          </div>
          
          <?php 
		  
			// do avtion, extend share on social metabox
			do_action( 'cwp2s_share_on_social_metabox', $post_id ); // <- extensible 
		  
		  ?>
        
        </div>
        
		</div>
		
		<?php
		
	}
	
	/**
	 * Save Metabox.
	 *
	 * @since 1.0.0
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	public function save_share_on_social( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_action = 'cwp2s_share_on_social_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $_POST['cwp2s_share_on_social_nonce'] ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $_POST['cwp2s_share_on_social_nonce'], $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// auto post
		if ( isset($_POST['cwp2s_auto_post']) ) {
			$auto_post = '1';
		} else {
			$auto_post = '';
		}
		
		// auto post save
		if ( $auto_post == '1' ) {
			update_post_meta($post_id,'_cwp2s_auto_post', $auto_post);
		} else {
			delete_post_meta($post_id,'_cwp2s_auto_post');
		}
		
		// twitter auto posting
		if ( isset($_POST['cwp2s_twitter_auto_posting']) ) {
			$twitter_auto_posting = '1';
		} else {
			$twitter_auto_posting = '';
		}
		// twitter auto posting save
		if ( $twitter_auto_posting == '1' ) {
			update_post_meta($post_id,'_cwp2s_twitter_auto_posting', $twitter_auto_posting);
		} else {
			delete_post_meta($post_id,'_cwp2s_twitter_auto_posting');
		}
			
		$twitter_cards_options     = get_option('cwp2s_twitter_cards_options');
		$twitter_card_type_default = isset( $twitter_cards_options['twitter_card_type'] ) ? sanitize_text_field( $twitter_cards_options['twitter_card_type'] ) : '';
		if ( $twitter_card_type_default == '' ) {
			$twitter_card_type_default = 'summary'; // def
		}
		
		$twitter_card_type  = isset( $_POST['cwp2s_twitter_card_type'] ) ? sanitize_text_field( $_POST['cwp2s_twitter_card_type'] ) : '';
		
		// summary is the default type
		if ( $twitter_card_type == $twitter_card_type_default ) {
			delete_post_meta($post_id,'_cwp2s_twitter_card_type');
		} else {
			update_post_meta($post_id,'_cwp2s_twitter_card_type', $twitter_card_type);
		}
		
		// post on social networks only if auto post enabled
		if ( $auto_post == '1' && $twitter_auto_posting == '1' ) {
			$twitter_data = array(
				'post_id'              => $post_id,
				'auto_post'            => $auto_post, // 1 or empty 
				'twitter_auto_posting' => $twitter_auto_posting, // 1 or empty 
				'twitter_card_type'    => $twitter_card_type
			);
			$twitter_data = json_encode($twitter_data); // json encode before send
			// do avtion, process to post
			do_action( 'cwp2s_process_twitter_auto_posting', $twitter_data ); // <- extensible 
		}
		
		/*
		echo '<pre>';
		print_r( $twitter_data );
		echo '</pre>';
		exit;
		*/
		
	}
						
}

?>
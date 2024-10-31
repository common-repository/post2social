
<?php 

$enable_twitter_auto_post  = isset( $twitter_auto_post_options['enable_twitter_auto_post'] ) ? sanitize_text_field( $twitter_auto_post_options['enable_twitter_auto_post'] ) : '';	
$twitter_account_name  = isset( $twitter_auto_post_options['twitter_account_name'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_account_name'] ) : '';			
$twitter_api_key  = isset( $twitter_auto_post_options['twitter_api_key'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_api_key'] ) : '';
$twitter_api_secret_key  = isset( $twitter_auto_post_options['twitter_api_secret_key'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_api_secret_key'] ) : '';
$twitter_access_token  = isset( $twitter_auto_post_options['twitter_access_token'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_access_token'] ) : '';
$twitter_access_token_secret  = isset( $twitter_auto_post_options['twitter_access_token_secret'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_access_token_secret'] ) : '';

$twitter_words_to_hashtags  = isset( $twitter_auto_post_options['twitter_words_to_hashtags'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_words_to_hashtags'] ) : '';

$post_types = Post2Social_Admin::get_registered_post_types();

/*

echo '<pre>';
print_r( $post_types );
echo '</pre>';


$taxonomies = Post2Social_Admin::get_registered_taxonomies();

echo '<pre>';
print_r( $taxonomies );
echo '</pre>';

foreach ($taxonomies as $taxonomy) {
	$taxonomy_obj = get_taxonomy($taxonomy);
	$terms = get_terms($taxonomy, array('hide_empty' => 0));
	if (count($terms) > 0) {
		echo '<br>' . $taxonomy_obj->label . '<br>';
		foreach ($terms as $term) {
			echo $term->term_id . ' ' . $term->name . '<br>';
		}
	}
}

*/
?>

<section>

<!-- section box -->
<div class="section-box padding-top-bottom-15">

<!-- padding content -->
<div class="padding-left-right-15">

<div class="row">

<!-- jquery -->
<div class="show-return-data"></div>

<!-- cw-admin-forms -->
<div class="cw-admin-forms padding-bottom-25">

<form action="" method="post" id="cwp2s-twitter-auto-post-form">

<input type="hidden" name="cwp2s-twitter-auto-post-form-nonce" value="<?php echo wp_create_nonce('cwp2s_twitter_auto_post_form_nonce'); ?>"/>

<div class="col-6">

<div class="padding-left-right-10">

<h3><?php _e('Twitter Account', 'post2social'); ?></h3>

  <div class="inputbox">
    <label for="twitter_account_name"><?php _e("Account Name", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Enter your account name. (optional)", 'post2social') ; ?>"></span>
    </label>
      <input style="width:80%;" id="twitter_account_name" name="twitter_account_name" type="text" value="<?php echo esc_attr( $twitter_account_name ); ?>">
  </div>

<p>
<?php 
$app_link = '<a href="https://apps.twitter.com/" target="_blank">' . 'https://apps.twitter.com/' . '</a>';
$go_to_apps = sprintf( __( 'The following keys are required for Twitter Auto Post. Please go to %s and create your Twitter app then enter your keys.', 'post2social' ), $app_link );
echo $go_to_apps;
?>

</p>

  <div class="inputbox">
    <label for="twitter_api_key"><?php _e("API Key", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Please visit https://apps.twitter.com/ and create a new app then enter your API Key.", 'post2social') ; ?>"></span>
    </label>
      <input id="twitter_api_key" name="twitter_api_key" type="text" value="<?php echo esc_attr( $twitter_api_key ); ?>">
  </div>
  
  <div class="inputbox">
    <label for="twitter_api_secret_key"><?php _e("API Secret", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Please visit https://apps.twitter.com/ and create a new app then enter your API Secret Key.", 'post2social') ; ?>"></span>
    </label>
      <input id="twitter_api_secret_key" name="twitter_api_secret_key" type="text" value="<?php echo esc_attr( $twitter_api_secret_key ); ?>">
  </div>
  
  <div class="inputbox">
    <label for="twitter_access_token"><?php _e("Access Token", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Please visit https://apps.twitter.com/ and create a new app then enter your Access Token.", 'post2social') ; ?>"></span>
    </label>
      <input id="twitter_access_token" name="twitter_access_token" type="text" value="<?php echo esc_attr( $twitter_access_token ); ?>">
  </div>
  
  <div class="inputbox">
    <label for="twitter_access_token_secret"><?php _e("Access Token Secret", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Please visit https://apps.twitter.com/ and create a new app then enter your Access Token Secret.", 'post2social') ; ?>"></span>
    </label>
      <input id="twitter_access_token_secret" name="twitter_access_token_secret" type="text" value="<?php echo esc_attr( $twitter_access_token_secret ); ?>">
  </div>

</div>    
</div><!--/ col --> 

<div class="col-6">

<div class="padding-left-right-10">

<h3><?php _e('Twitter Auto Post', 'post2social'); ?></h3>
    
  <div class="checkbox margin-bottom-5">   
    <input type="checkbox" value="1" <?php echo ($enable_twitter_auto_post == '1') ? 'checked' : '' ?> id="enable_twitter_auto_post" name="enable_twitter_auto_post" />
    <span><?php _e("Enable Twitter Auto Post", 'post2social'); ?> </span>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If enabled Twitter Auto Post will be displayed on the selected posts, pages and custom post type pages Share on Social metabox. You can define the allowed post types on the General Settings page.", 'post2social') ; ?>"></span>
  </div>

  <div class="inputbox">
    <label for="twitter_words_to_hashtags"><?php _e("Auto Convert Words into Hashtags", 'post2social'); ?>  
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If the added word exist in the tweet title or description it will be auto converted into hashtags. E.g. wordpress will become to #wordpress", 'post2social') ; ?>"></span>
    </label>
    <span><?php _e("Words should be separated by comma ( , ).", 'post2social'); ?></span>
      <textarea id="twitter_words_to_hashtags" name="twitter_words_to_hashtags"  rows="3" maxlength="300" ><?php echo esc_textarea( stripslashes( $twitter_words_to_hashtags ) ); ?></textarea>
  </div>

    <div class="formsubmit">
        <button class="btn btn-mdl btn-wp-blue float-right margin-top-10" name="cwp2s-options-form-submit" type="submit"> 
        <i class="glyphicon glyphicon-edit"></i>&nbsp; <?php esc_attr_e('Save Changes', 'post2social'); ?>
        </button>
    </div>

</div>
</div><!--/ col -->   
    
</form>

</div>
<!--/ cw-admin-forms -->


</div><!--/ row -->


</div>
<!--/ padding content -->

</div>
<!--/ section box -->

</section>
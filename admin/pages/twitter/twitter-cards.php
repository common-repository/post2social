
<?php 

$enable_twitter_cards  = isset( $twitter_cards_options['enable_twitter_cards'] ) ? sanitize_text_field( $twitter_cards_options['enable_twitter_cards'] ) : '';
$twitter_username  = isset( $twitter_cards_options['twitter_username'] ) ? sanitize_text_field( $twitter_cards_options['twitter_username'] ) : '';
$twitter_card_type  = isset( $twitter_cards_options['twitter_card_type'] ) ? sanitize_text_field( $twitter_cards_options['twitter_card_type'] ) : '';

$include_meta_title  = isset( $twitter_cards_options['include_meta_title'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_title'] ) : '';
$include_meta_description  = isset( $twitter_cards_options['include_meta_description'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_description'] ) : '';
$include_meta_url  = isset( $twitter_cards_options['include_meta_url'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_url'] ) : '';
$include_meta_image  = isset( $twitter_cards_options['include_meta_image'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_image'] ) : '';
$include_meta_creator  = isset( $twitter_cards_options['include_meta_creator'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_creator'] ) : '';
$include_meta_site  = isset( $twitter_cards_options['include_meta_site'] ) ? sanitize_text_field( $twitter_cards_options['include_meta_site'] ) : '';

$get_twitter_card_types = Post2Social_Twitter_Cards::get_twitter_card_types();

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

<form action="" method="post" id="cwp2s-twitter-cards-form">

<input type="hidden" name="cwp2s-twitter-cards-form-nonce" value="<?php echo wp_create_nonce('cwp2s_twitter_cards_form_nonce'); ?>"/> 

<div class="col-6">

<div class="padding-left-right-10">

<h3><?php _e('Twitter Cards', 'post2social'); ?></h3>

  <div class="checkbox margin-top-10 margin-bottom-5">
    <label for="enable_twitter_cards"><?php _e("Twitter Cards Meta", 'post2social'); ?></label>
  </div>
    
  <div class="checkbox margin-bottom-15">   
    <input type="checkbox" value="1" <?php echo ($enable_twitter_cards == '1') ? 'checked' : '' ?> id="enable_twitter_cards" name="enable_twitter_cards" />
    <span><?php _e("Enable Twitter Cards Meta", 'post2social'); ?> </span>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If enabled Twitter Cards Meta tags will be inserted into every of your pages source code.", 'post2social') ; ?>"></span>
  </div>

  <div class="inputbox">
    <label for="twitter_username"><?php _e("Twitter Username", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Your Twitter Username without @", 'post2social') ; ?>"></span>
    </label>
      @<input style="width: 70%;" id="twitter_username" name="twitter_username" type="text" value="<?php echo esc_attr( $twitter_username ); ?>">
  </div>
  
  <div class="inputbox">
    <label for="twitter_card_type">
	<?php _e('Card Type', 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( 'Default Twitter Card Type for all posts, pages, categories and CPTs.', 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:card" content="summary" /&gt;</span>
     </label>  
        <select style="width:80%;" id="twitter_card_type" name="twitter_card_type">
			<?php 
            foreach ($get_twitter_card_types as $key => $value ) {
				
				if ( $twitter_card_type == $key ) {
				  echo '<option selected="selected" value="' . esc_attr( $key ) . '">' . esc_attr( $value ) . '</option>';  
				}
				
            ?>
              <option value="<?php esc_attr_e($key); ?>"><?php esc_attr_e($value); ?></option>
            <?php 
            }
            ?>
        </select>
  </div>
  


</div>    
</div><!--/ col --> 

<div class="col-6">

<div class="padding-left-right-10">

<h3><?php _e('Twitter Cards Meta Tags', 'post2social'); ?></h3>

  <div class="checkbox margin-top-10 margin-bottom-5">
    <label for="twitter_card_tags"><?php _e("Meta Tags", 'post2social'); ?></label>
  </div>
    
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_title == '1') ? 'checked' : '' ?> id="include_meta_title" name="include_meta_title" />
	<?php _e("Include Meta Title", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If checked Meta Title will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:title" content="..." /&gt;</span>
  </div>
  
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_description == '1') ? 'checked' : '' ?> id="include_meta_description" name="include_meta_description" />
	<?php _e("Include Meta Description", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If checked Meta Description will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:description" content="..." /&gt;</span>
  </div>
  
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_url == '1') ? 'checked' : '' ?> id="include_meta_url" name="include_meta_url" />
	<?php _e("Include Meta URL", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If checked Meta URL will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:url" content="..." /&gt;</span>
  </div>
  
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_image == '1') ? 'checked' : '' ?> id="include_meta_image" name="include_meta_image" />
	<?php _e("Include Meta Image", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If checked Meta Image will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:image" content="..." /&gt;</span>
  </div>
  
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_creator == '1') ? 'checked' : '' ?> id="include_meta_creator" name="include_meta_creator" />
	<?php _e("Include Post/Page Author", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "If checked Meta Creator will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:creator" content="@..." /&gt;</span>
  </div>
  
  <div class="checkbox">   
    <input type="checkbox" value="1" <?php echo ($include_meta_site == '1') ? 'checked' : '' ?> id="include_meta_site" name="include_meta_site" />
	<?php _e("Include Publisher", 'post2social'); ?> 
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The Publisher is the Twitter Username. If checked Meta Site will be included on Twitter meta tags.", 'post2social') ; ?>"></span>
    <span class="meta-code">&lt;meta name="twitter:site" content="@..." /&gt;</span>
  </div>
  
  <p>
  <?php _e("Validate your Twitter Card settings via Twitter's Validation Tool: ", 'post2social'); ?>
  <a href="https://cards-dev.twitter.com/validator" target="_blank"><?php _e("Validate", 'post2social'); ?></a>
  </p>

    <div class="formsubmit">
        <button class="btn btn-mdl btn-wp-blue float-right margin-top-10" name="cwp2s-options-form-submit" type="submit"> 
        <i class="glyphicon glyphicon-edit"></i>&nbsp; <?php esc_attr_e('Save Changes', 'post2social') ?>
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
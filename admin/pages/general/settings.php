
<?php 

$homepage_image_url  = isset( $general_options['homepage_image_url'] ) ? sanitize_text_field( $general_options['homepage_image_url'] ) : '';
$homepage_description  = isset( $general_options['homepage_description'] ) ? sanitize_text_field( $general_options['homepage_description'] ) : '';
$default_image_url  = isset( $general_options['default_image_url'] ) ? sanitize_text_field( $general_options['default_image_url'] ) : '';
$default_description  = isset( $general_options['default_description'] ) ? sanitize_text_field( $general_options['default_description'] ) : '';
$default_image_type  = isset( $general_options['default_image_type'] ) ? sanitize_text_field( $general_options['default_image_type'] ) : ''; // radio
$image_custom_field_name = isset( $general_options['image_custom_field_name'] ) ? sanitize_text_field( $general_options['image_custom_field_name'] ) : '';

$share_on_social_metabox  = isset( $general_options['share_on_social_metabox'] ) ? sanitize_text_field( $general_options['share_on_social_metabox'] ) : '';
if ( ! empty($share_on_social_metabox) ) {
    $share_on_social_metabox   = json_decode($share_on_social_metabox, true); // convert to array
} else {
	$share_on_social_metabox = ''; // def
}
/*
echo '<pre>';
print_r( $share_on_social_metabox );
echo '</pre>';
*/
$post_types = Post2Social_Admin::get_registered_post_types();

?>

<section>

<!-- section box -->
<div class="section-box padding-top-bottom-15">

<!-- padding content -->
<div class="padding-left-right-15">

<div class="row">

<!-- jquery -->
<div class="general-settings-response"></div>

<!-- cw-admin-forms -->
<div class="cw-admin-forms padding-bottom-25">

<form action="" method="post" id="cwp2s-general-settings-form">

<input type="hidden" name="cwp2s-general-settings-form-nonce" value="<?php echo wp_create_nonce('cwp2s_general_settings_form_nonce'); ?>"/> 

<div class="col-6">

<div class="padding-left-right-10">

<h3><?php _e('General Settings', 'post2social'); // that will apply to all networks ?></h3>

<p><?php _e('The above settings are active only if you have enabled "Enable Twitter Cards Meta" on the Twitter->Twitter Cards page.', 'post2social'); ?></p>

  <div class="inputbox">
    <label for="homepage_image_url"><?php _e("Homepage Image URL", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The image to be used on the homepage if has no image.", 'post2social') ; ?>"></span>
    </label>
     <input style="width:70%;" id="upload_image" name="homepage_image_url" type="text" value="<?php echo esc_attr( $homepage_image_url ); ?>">
        <a href="/" class="upload_image_button btn btn-md btn-grey" id="upload_image_button">
        <i class="glyphicon glyphicon-level-up"></i>&nbsp; <?php _e("Select Image", 'post2social'); ?>
        </a>
  </div>
  
  <div class="inputbox">
    <label for="homepage_description"><?php _e("Homepage Description", 'post2social'); ?>  
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The description to be used on the homepage if has no description.", 'post2social') ; ?>"></span>
    </label>
      <textarea id="homepage_description" name="homepage_description"  rows="3" maxlength="140" ><?php echo esc_textarea( stripslashes( $homepage_description ) ); ?></textarea>
  </div>
  
  <div class="inputbox">
    <label for="default_image_url"><?php _e("Default Image URL", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The default image to be used on any post, page, custom post that has no image.", 'post2social') ; ?>"></span>
    </label>
     <input style="width:70%;" id="upload_default_image" name="default_image_url" type="text" value="<?php echo esc_attr( $default_image_url ); ?>">
        <a href="/" class="upload_image_button btn btn-md btn-grey" id="upload_default_image_button">
        <i class="glyphicon glyphicon-level-up"></i>&nbsp; <?php _e("Select Image", 'post2social'); ?>
        </a>
  </div>
  
  <div class="inputbox">
    <label for="default_description"><?php _e("Default Description", 'post2social'); ?>  
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The default description to be used on any post, page, custom post that has a blank description.", 'post2social') ; ?>"></span>
    </label>
      <textarea id="default_description" name="default_description"  rows="3" maxlength="140" ><?php echo esc_textarea( stripslashes( $default_description ) ); ?></textarea>
  </div>
  
  <div class="radiobox margin-top-10 margin-bottom-5">
    <label for="default_image_type"><?php _e("Image Type", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Default image type for all posts, pages, categories and CPTs.", 'post2social') ; ?>"></span>
    </label>
  </div>
    
  <div class="radiobox">
    <?php 
	$checked = ''; // def
	$image_options = Post2Social_General::default_image_options();
	foreach ($image_options as $key => $value ) {
		
		if ( ! empty($default_image_type) ) {
			if( $key == trim($default_image_type) ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
		} 
		
	?>
    <div class="display-block twitter-cards-image" style=" line-height:1.6em;">
        <input type="radio" value="<?php esc_attr_e($key); ?>" <?php echo $checked; ?>  name="default_image_type" />
        <span><?php esc_attr_e($value); ?> </span>
    </div>
    <?php 
	}
	?>
  </div>
  
  <?php 
  
  $display = ''; // def
  if ( isset($default_image_type) && $default_image_type == 'custom_field' ) {
	  $display = 'style="display:block;"';
  }
  
  ?>
  
  <div class="inputbox image-custom-field-name" <?php echo $display; ?> >
    <label for="image_custom_field_name"><?php _e("Image Custom Field Name", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Enter the image custom field name from you want to use the image.", 'post2social') ; ?>"></span>
    </label>
      <input style="width:80%;" id="image_custom_field_name" name="image_custom_field_name" type="text" value="<?php echo esc_attr( $image_custom_field_name ); ?>">
  </div>

</div>    
</div><!--/ col --> 

<div class="col-6">

<div class="padding-left-right-10">

  <div class="checkbox margin-top-10 margin-bottom-5">
    <label for="share_on_social_metabox"><?php _e("Display the Share on Social Metabox", 'post2social'); ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "The Share on Social Metabox will be displayed on the selected post types view pages included with Twitter Cards and Auto Post features.", 'post2social') ; ?>"></span>
    </label>
  </div>
    
  <div class="checkbox">
    <?php 
	$checked = ''; // def
	foreach ($post_types as $key => $value ) {
		if ( ! empty($share_on_social_metabox) ) {
			if( in_array( $value ,$share_on_social_metabox ) ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
		}
		
		$value = str_replace("_"," ",$value); // replace underscore
	?>
    <div class="display-block" style=" line-height:1.6em;">
        <input type="checkbox" value="<?php esc_attr_e($key); ?>" <?php echo $checked; ?> id="share_on_social_metabox" name="share_on_social_metabox[]" />
        <span><?php esc_attr_e(ucwords($value)); ?> </span>
    </div>
    <?php 
	}
	?>
  </div>

    <div class="formsubmit">
        <button class="btn btn-mdl btn-wp-blue float-right margin-top-10" name="cwp2s-general-settings-form-submit" type="submit"> 
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
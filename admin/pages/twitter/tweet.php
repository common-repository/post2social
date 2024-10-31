

<?php 

$twitter_api_key  = isset( $twitter_auto_post_options['twitter_api_key'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_api_key'] ) : '';
$twitter_api_secret_key  = isset( $twitter_auto_post_options['twitter_api_secret_key'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_api_secret_key'] ) : '';
$twitter_access_token  = isset( $twitter_auto_post_options['twitter_access_token'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_access_token'] ) : '';
$twitter_access_token_secret  = isset( $twitter_auto_post_options['twitter_access_token_secret'] ) ? sanitize_text_field( $twitter_auto_post_options['twitter_access_token_secret'] ) : '';


$twitter_username = isset( $twitter_cards_options['twitter_username'] ) ? sanitize_text_field( $twitter_cards_options['twitter_username'] ) : '';

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

<div class="col-4">

<div class="padding-left-right-10">

<?php
if ( !empty($twitter_username) ) {
    require_once POST2SOCIAL_DIR . 'admin/pages/twitter/includes/latest-tweets-v2.php'; 
} else {
?>

  <h3 class="tweet-title"><?php _e("Tweets", 'post2social');  ?></h3>
    
  <p>
  <?php _e("Latest Tweets can be displayed only if you have entered your 'Twitter Username' on the Twitter Cards page.", 'post2social'); ?>
  </p> 
    
<?php 
}
?> 

</div>    
</div><!--/ col --> 

<div class="col-8">

<div class="padding-left-right-10">

<?php 
if ( !empty($twitter_api_key) || !empty($twitter_api_secret_key) || !empty($twitter_access_token) || !empty($twitter_access_token_secret) ) {
    require_once POST2SOCIAL_DIR . 'admin/pages/twitter/includes/tweet-box.php'; 
} else {
?>

  <h3 class="tweet-title"><?php _e("What's happening?", 'post2social');  ?></h3>
    
  <p>
  <?php _e("Twitter Tweets Box can be displayed only if you have entered your 'Twitter Username' on the Twitter Cards page and the 'API Keys' on the Twitter Auto Post page.", 'post2social'); ?>
  </p> 
    
<?php 
}
?> 

</div>
</div><!--/ col -->   



</div>
<!--/ cw-admin-forms -->


</div><!--/ row -->


</div>
<!--/ padding content -->

</div>
<!--/ section box -->

</section>
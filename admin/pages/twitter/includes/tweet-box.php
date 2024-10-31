
<?php 

// manual tweet box
$twitter_username = isset( $twitter_cards_options['twitter_username'] ) ? sanitize_text_field( $twitter_cards_options['twitter_username'] ) : '';

$text	= 'Hello World';
$url	= home_url();
$via    = 'via @' . $twitter_username;

//$tweet = $text . ' ' . $via;
$tweet = $text;

if ( !empty($twitter_username) ) {
?>

<!-- jquery -->
<div class="twitter-tweet-response"></div>

<div class="cw-admin-forms">

<form action="" method="post" id="cwp2s-twitter-tweet-box-form">

<input type="hidden" name="cwp2s-twitter-tweet-box-form-nonce" value="<?php echo wp_create_nonce('cwp2s_twitter_tweet_box_form_nonce'); ?>"/> 

    <h3 class="tweet-title"><?php _e("What's happening?", 'post2social'); // Share a link with your followers  ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Share a link and a short message on Twitter.", 'post2social') ; ?>"></span>
    </h3>

  <div class="inputbox">
    <div class="char_counter"><i id="twitter_char_count">115</i> <?php _e('characters left', 'post2social'); ?> </div>
      <textarea style="border-radius:4px; border-width:1px; border-color:#e6ecf0; font-size: 14px;" id="twitter_tweet_message" name="twitter_tweet_message"  rows="2" maxlength="115" ><?php echo $tweet; ?></textarea>
  </div>
  
  <div class="inputbox">
    <label style="color: #66757f;">
    <?php esc_attr_e('URL:', 'post2social') ?>
    <span class="cwp2s-tooltip tooltip-info-icon" title="<?php _e( "Any long URLs are accepted. URL will be auto shorten via Twitter.", 'post2social') ; ?>"></span> 
    </label>
    <input style="border-radius:4px; border-width:1px; border-color:#e6ecf0; font-size: 14px; width:80%;" type="text" id="twitter_tweet_url" name="twitter_tweet_url" value="<?php echo $url; ?>"/> 
  </div>

    <div class="formsubmit">
        <button class="btn btn-mdl btn-tweet float-right margin-top-10" name="cwp2s-twitter-tweet-box-form-submit" type="submit"> 
        <i class="glyphicon glyphicon-edit"></i>&nbsp; <?php esc_attr_e('Tweet', 'post2social') ?>
        </button>
    </div>
    
</form>

</div>
    
  <p>
  <?php _e("My Twitter Site: ", 'post2social'); ?>
  <a href="<?php echo 'https://twitter.com/' . trim(esc_attr( $twitter_username )); ?>" target="_blank">
  <?php echo 'https://twitter.com/' . trim(esc_attr( $twitter_username )); ?>
  </a>
  </p> 
  
  
<?php 
}
?>
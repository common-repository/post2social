
<?php 
// source: https://dev.twitter.com/web/embedded-timelines
$twitter_username = isset( $twitter_cards_options['twitter_username'] ) ? sanitize_text_field( $twitter_cards_options['twitter_username'] ) : '';
?>

<div class="tweet-box">
      <div class="tweets-widget">            
       <a class="twitter-timeline" href="https://twitter.com/<?php echo trim(esc_attr( $twitter_username )); ?>">
       <?php _e('Tweets by', 'post2social'); ?> <?php echo trim(esc_attr( $twitter_username )); ?>
       </a> 
       <!--<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>-->
    </div>
</div>
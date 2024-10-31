
<div class="row padding-left-right-15  margin-top-25 padding-bottom-15" style="vertical-align:middle;"> 

<div class="col-9">

    <div class="cw-plugin-logo">
    <a href="https://codeweby.com/" target="_blank">
    <img class="responsive" src="<?php echo esc_url( POST2SOCIAL_URL . 'admin/assets/images/Post2Social-Logo-v2.png' ); ?>" alt="Post2Social">
    </a>
    </div>  
    <span class="padding-right-25 font-14"><?php _e("Version: ", 'post2social'); ?> <?php echo esc_attr( $plugin_version ); ?></span>
<?php 
$main_pages_tabs = Post2Social_Admin::main_pages_tabs();
/*
echo '<pre>';
print_r( $main_pages_tabs );
echo '</pre>';
*/

foreach( $main_pages_tabs as $key => $value ){ 
$url = home_url() . '/wp-admin/admin.php?page=post2social&main=' . $key;

// set up button colors and glyphicons
// $key == folder name
if ( $key == 'general' ) {
	$btn_color = 'btn-grey-settings';
	$glyphicon = 'class="glyphicon glyphicon-wrench"';
} elseif ( $key == 'auto-publish' ) {
	$btn_color = 'btn-grey-settings';
	$glyphicon = 'class="glyphicon glyphicon-refresh"';
} else {
    // default
	$btn_color = 'btn-wp-blue';
	$glyphicon = 'class="glyphicon glyphicon-user"';
}

?>    
    <a href="<?php echo esc_url( $url ); ?>" class="btn btn-mdl <?php echo $btn_color; ?>">
    <i <?php echo $glyphicon; ?>></i>&nbsp; <?php _e($value, 'post2social'); ?>
    </a>
<?php 
}
?>
    
</div>

<div class="col-3">

<a class="twitter-follow-button" href="https://twitter.com/codeweby" data-show-count="false" data-size="large">
<?php _e("Follow", 'post2social'); ?> @Codeweby
</a>

</div>

</div>
<!--/ row -->
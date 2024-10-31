
<div class="cw-menu-tabs">
   <ul>
<?php 
$sub_pages_tabs = Post2Social_Admin::sub_pages_tabs($main);

foreach( $sub_pages_tabs as $key => $value ){ 
$url = home_url() . '/wp-admin/admin.php?page=post2social&main=' . $main . '&sub=' . $key;
?>
   <li><a href="<?php echo esc_url( $url ); ?>"><?php _e($value, 'post2social'); ?></a></li>
<?php 
}
?>     
   </ul>
</div>
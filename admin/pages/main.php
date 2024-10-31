<?php 
if( isset($_GET['page']) && $_GET['page'] == "post2social"){ 

$main = ''; // def
$sub  = ''; // def

##### folder name #######
if( isset($_GET['main']) ) {
   $main = $_GET['main'];
} else {
   $main = 'twitter'; // default main page 
}

if( isset($_GET['sub']) ) {
   $sub = $_GET['sub'];
} else {
	
	// default sub pages
   if ( $main == 'general' ) {
	  $sub = 'settings'; 
   } elseif ( $main == 'twitter' ) {
	  $sub = 'tweet'; 
   }
   
}

$plugin_data    = get_plugin_data( POST2SOCIAL_PLUGIN_FILE );
$plugin_version = $plugin_data['Version'];

/*
echo '<pre>';
print_r( $plugin_data );
echo '</pre>';
*/

?>

<div id="post2social-admin"> 

<!-- main menu tabs -->
<?php 
// main menu tabs
require_once POST2SOCIAL_DIR . 'admin/pages/_includes/main-menu-tabs.php'; // twitter, facebook etc.
?>
<!--/ main menu tabs -->

<!-- menu tabs -->
<?php 
// sub menu tabs
require_once POST2SOCIAL_DIR . 'admin/pages/_includes/sub-menu-tabs.php'; 
?>
<!--/ menu tabs -->

<div class="row"> 

<!----------------------- page content left -->
<article class="col-9">

<?php 
// page content
if ( file_exists( POST2SOCIAL_DIR . 'admin/pages/' . $main . '/' . $sub . '.php' ) ) {
  require POST2SOCIAL_DIR . 'admin/pages/' . $main . '/' . $sub . '.php';
} else {
  // make it extensible
  do_action( 'cwp2s_admin_add_sub_pages', $main, $sub ); // <- extensible	
}

?>

</article>
<!-----------------------/ page content left -->


<!----------------------- page content right -->
<aside class="col-3">
<?php 
// aside boxes
if ( file_exists( POST2SOCIAL_DIR . 'admin/pages/' . $main . '/includes/' . $main . '-aside.php' ) ) {
  require POST2SOCIAL_DIR . 'admin/pages/' . $main . '/includes/' . $main . '-aside.php';
} else {
  // make it extensible
  do_action( 'cwp2s_admin_add_sub_pages_aside', $main, $sub ); // <- extensible	
}
?>
</aside>
<!-----------------------/ page content right -->

</div>
<!--/ row -->

<!-- footer -->
<div class="row"> 
<div class="col-12">
<!-- padding content -->
<div class="padding-left-right-25">
<p><?php _e('Developed by:', 'post2social'); ?> <a href="https://www.codeweby.com/" target="_blank">Codeweby</a></p>
</div>
<!--/ padding content -->
</div>
</div>
<!--/ row -->

</div> <!--/ #codeweby-admin -->

<?php 
}
?>
<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

class Post2Social_Public
{
  
  public function public_method_name() {	
       // do stuff
  }

	
  // Enqueue Styles
  public function public_enqueue_styles() {	
	  wp_enqueue_style( 'post2social_public_css', POST2SOCIAL_URL . 'public/assets/css/public.css', array(), '', 'all' );
  }
  
  // Enqueue Scripts
  public function public_enqueue_scripts() {	
    wp_enqueue_script( 'post2social_public_js', POST2SOCIAL_URL . 'public/assets/js/public.js', array( 'jquery' ), '', true ); 
  }
	
}

?>
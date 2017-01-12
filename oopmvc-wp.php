<?php
/**
* Plugin Name: OOPMVC-WP
* Plugin URI: http://www.oopmvc.com/portfolios/wordpress/plugins/oopmvc-wp
* Description: Wordpress with Vue.js front end. 
* Version: 1.0 
* Author: Shahinul Islam
* Author URI: http://www.oopmvc.com/team/shahinul-islam
* License: MIT 
*/
  
register_activation_hook( __FILE__,   'oopmvc_vuewptraining_up' );
register_deactivation_hook( __FILE__, 'oopmvc_vuewptraining_down' );

/**
* Register the plugins 
*/

function oopmvc_vuewptraining_up(){ 
   
}

/**
* De-register the plugins 
*/
function oopmvc_vuewptraining_down(){
	 

}
  
function oopmvc_hide_default_plugins() {
  echo '<style>
   #toplevel_page_edit-post_type-acf,
   #toplevel_page_cptui_main_menu,
   a[href="options-general.php?page=codepress-admin-columns"] 
   
   { display: none !important;}
  </style>';
}
add_action('admin_head', 'oopmvc_hide_default_plugins');


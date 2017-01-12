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

include dirname(__FILE__).'/adminsettings.php';
include dirname(__FILE__).'/hidedefault.php';

// adding wp_head settings in front end 
function oopmvc_frontend_head(){   $options = get_option('oopmvcwp_options');    echo $options['general_wp_head'];  }
add_action('wp_head', 'oopmvc_frontend_head');

// adding wp_footer settings in front end 
function oopmvc_frontend_footer(){ $options = get_option('oopmvcwp_options');   echo $options['general_wp_footer']; }
add_action('wp_footer', 'oopmvc_frontend_footer'); 


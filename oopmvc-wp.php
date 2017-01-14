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
include dirname(__FILE__).'/add_shortcode.php';
include dirname(__FILE__).'/vue_module.php';
include dirname(__FILE__).'/editarea_syntax.php';
include dirname(__FILE__).'/training.php';

$oopmvc_all_js_scripts = array();

// adding wp_head settings in front end 
function oopmvc_frontend_head(){   
	$options = get_option('oopmvcwp_options');  echo $options['general_wp_head'];  
}
add_action('wp_head', 'oopmvc_frontend_head');

// adding wp_footer settings in front end 
function oopmvc_frontend_footer(){ 

	/*
		<script src="https://unpkg.com/vue/dist/vue.js"></script>
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	*/

	$options = get_option('oopmvcwp_options');   echo $options['general_wp_footer']; 

	global $oopmvc_all_js_scripts;
	foreach ($oopmvc_all_js_scripts as $key => $value) {
		echo $value;
	}
}
add_action('wp_footer', 'oopmvc_frontend_footer'); 


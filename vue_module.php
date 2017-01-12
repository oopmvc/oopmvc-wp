<?php 
function cptui_register_my_cpts_vue_module() {

	/**
	 * Post Type: Vue.js Modules.
	 */

	$labels = array(
		"name" => __( 'Vue.js Modules', 'twentysixteen' ),
		"singular_name" => __( 'Vue.js Module', 'twentysixteen' ),
	);

	$args = array(
		"label" => __( 'Vue.js Modules', 'twentysixteen' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => false,
		"query_var" => true,
		"supports" => array( "title" ),
	);

	register_post_type( "vue_module", $args );
}

add_action( 'init', 'cptui_register_my_cpts_vue_module' );





// register acf
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_vue-module-settings',
		'title' => 'Vue Module Settings',
		'fields' => array (
			array (
				'key' => 'field_5877988ded119',
				'label' => 'Vue Custom HTML',
				'name' => 'vue_custom_html',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '<div id="vue-root"></div>',
				'placeholder' => 'Vue.js Root element HTML',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_58778c204f1ac',
				'label' => 'Vue Custom JS',
				'name' => 'vue_custom_js',
				'type' => 'textarea',
				'default_value' => 'new Vue({el:"#vue-root"})',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'vue_module',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

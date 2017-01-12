<?php 

add_shortcode( 'oopmvc', 'oopmvc_shortcode_cb' );
function oopmvc_shortcode_cb( $atts ) {
    $atts = shortcode_atts( array(
        'v-script' => '' 
    ), $atts );

    $return = 'Plugins Required ( Contact Developer ) ';

 
    if(!empty($atts['v-script']) && function_exists('get_field')){ 
    
			$html_block = get_field('vue_custom_html', $atts['v-script'], false);
			$js_block   = get_field('vue_custom_js',   $atts['v-script'], false);
            
            global $oopmvc_all_js_scripts;
            $oopmvc_all_js_scripts[] = '<script type="text/javascript">'.   $js_block .'</script>';


		    $return = $html_block;  

	}

    return $return;
} 
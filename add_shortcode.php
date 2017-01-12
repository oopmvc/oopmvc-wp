<?php 

add_shortcode( 'oopmvc', 'oopmvc_shortcode_cb' );
function oopmvc_shortcode_cb( $atts ) {
    $atts = shortcode_atts( array(
        'root' => 'box'.time(),
        'customjs'  => '',
        'customcss'  => ''  
    ), $atts );

    $return = '<div id="'. $atts['root'].'"></div>';  
    return $return;
} 
<?php
function rbd_faqs_register_scripts() {
    if ( shortcode_exists('faqs') ) {
        wp_register_style( 'rbd-faqs-styles', plugins_url( '../public/css/faqs.min.css', __FILE__ ) );
    	wp_register_script( 'rbd-faqs-scripts', plugins_url( '../public/js/faqs.js', __FILE__ ), array('jquery'), '1.0', true );
    };
};
?>
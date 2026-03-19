<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
Plugin Name: RB Simple FAQs
Plugin URI: https://github.com/redballoonio/faq-plugin
Description: Display frequently asked questions with collapsable display options.
Version: 1.2.0
Author: Red Balloon Design Ltd.
Author URI: http://redballoon.io
License: GPLv2
*/

/*
View the readme here:
https://docs.google.com/spreadsheets/d/1apC0th0X_rq8ybvTDsp40lWcHfthdna8WMbAywX7DBU/pubhtml?gid=1345923635&single=true
*/

// Register the faq post type.
include plugin_dir_path( __FILE__ ) . 'inc/custom_post.php';
add_action( 'init', 'rbd_create_faqs' );
add_action( 'init', 'rbd_faqs_taxonomies', 0 );

// Add custom column.
include plugin_dir_path( __FILE__ ) . 'inc/custom_columns.php';

// Add settings page.
include plugin_dir_path( __FILE__ ) . 'inc/settings.php';

// Register the scripts.
include plugin_dir_path( __FILE__ ) . 'inc/scripts.php';
add_action( 'wp_enqueue_scripts', 'rbd_faqs_register_scripts' );

// Register the shortcode.
include plugin_dir_path( __FILE__ ) . 'inc/shortcode.php';
add_shortcode( 'faqs', 'rbd_faqs_shortcode' );

// Register the schema output.
include plugin_dir_path( __FILE__ ) . 'inc/schema.php';
?>
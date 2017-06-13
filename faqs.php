<?php
/*
Plugin Name: RB Simple FAQs
Plugin URI: https://github.com/redballoonio/faq-plugin
Description: Display frequently asked questions with collapsable display options.
Version: 1.1.0
Author: Red Balloon Design Ltd.
Author URI: http://redballoon.io
License: GPLv2
*/

/*

View the readme here:
https://docs.google.com/spreadsheets/d/1apC0th0X_rq8ybvTDsp40lWcHfthdna8WMbAywX7DBU/pubhtml?gid=1345923635&single=true

*/

/*
Changelog

--  --  1.0.4  --  --
* Update to how files are enqueued. The files are registered in this file and enqueued in the shortcode file.

--  --  1.0.3  --  --
* Added faqs_taxonomies

*/


// Register the faq post type.
include('inc/custom_post.php');
add_action( 'init', 'rbd_create_faqs' );
add_action( 'init', 'rbd_faqs_taxonomies', 0 );

// Add custom column.
include('inc/custom_columns.php');

// Add settings page
include('inc/settings.php');

// Register the scripts
include('inc/scripts.php');
add_action( 'wp_enqueue_scripts', 'rbd_faqs_register_scripts' );

// Register the shortcode
include('inc/shortcode.php');
add_shortcode('faqs', 'rbd_faqs_shortcode');
?>
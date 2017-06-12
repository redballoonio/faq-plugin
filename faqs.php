<?php
/*
Plugin Name: FAQs
Plugin URI: http://redballoon.io
Description: Ouput Faq section with built in show/hide.
Version: 1.0.4
Author: Red Balloon Digital
Author URI: http://redballoon.io
License: GPLv2
*/

/*

View the readme here:
https://docs.google.com/spreadsheets/d/1apC0th0X_rq8ybvTDsp40lWcHfthdna8WMbAywX7DBU/pubhtml?gid=1345923635&single=true

*/

/*

# Updates to make:

* Add filters to the content output?
*/

/*
Changelog

--  --  1.0.4  --  --
* Update to how files are enqueued. The files are registered here and enqueued in the shortcode file.

--  --  1.0.3  --  --
* Added faqs_taxonomies
*/
// Custom Post Type

add_action( 'init', 'rbd_create_faqs' );

function rbd_create_faqs() {
    register_post_type( 'faqs',
        array(
            'labels' => array(
                'name' => 'FAQs',
                'singular_name' => 'Question',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New FAQ',
                'edit' => 'Edit',
                'edit_item' => 'Edit',
                'new_item' => 'New FAQ',
                'view' => 'View',
                'view_item' => 'View Question',
                'search_items' => 'Search Questions',
                'not_found' => 'No Questions found',
                'not_found_in_trash' => 'No Questions found in Trash',
                'parent' => 'Parent Questions'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
			'taxonomies' => array('faqs_cat'),
            'map_meta_cap' => true,
            'has_archive' => false,
            'capability_type' => 'page'
        )
    );
}

// Taxonomies
add_action( 'init', 'rbd_faqs_taxonomies', 0 );
function rbd_faqs_taxonomies() {
    register_taxonomy(
        'faqs_cat',
        'faqs',
        array(
            'labels' => array(
                'name' => 'FAQ Category',
                'add_new_item' => 'Add New',
                'new_item_name' => "New"
            ),
            'show_tagcloud' => false,
            'show_ui' => true,
		    'show_admin_column' => true,
            'hierarchical' => true,
            'capability_type' => 'page'
        )
    );
}

// Scripts
function faqs_register_scripts() {
    if ( shortcode_exists('faqs') ) {
        wp_register_style( 'rbd-faqs-styles', plugins_url( 'css/faqs.min.css', __FILE__ ) );
    	wp_register_script( 'rbd-faqs-scripts', plugins_url( 'js/faqs.js', __FILE__ ), array('jquery'), '1.0', true );
    };
};
add_action( 'wp_enqueue_scripts', 'faqs_register_scripts' );

// Shortcodes
add_shortcode('faqs', 'rbd_faqs_shortcode');
include('inc/shortcode.php');
?>
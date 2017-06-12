<?php
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
};

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
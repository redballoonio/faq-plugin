<?php
function rbd_faq_add_column($columns){
	$columns['id'] = __('ID');
    return $columns;
}

add_action('manage_edit-faqs_columns', 'rbd_faq_add_column', 10, 1);

function rbd_faq_manage_custom_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		/* If displaying the 'duration' column. */
		case 'id' :
			echo $post_id;
			break;
		default :
			break;
	}
}

add_action( 'manage_faqs_posts_custom_column', 'rbd_faq_manage_custom_columns', 10, 2 );


function rbd_faq_footer_function() {
	echo '<style>.post-type-faqs table.posts th.column-id { width: 50px; }</style>';
}

add_action('admin_footer', 'rbd_faq_footer_function');
?>
<?php
// inc/schema.php

global $rbd_faq_schema_items;
$rbd_faq_schema_items = array();

/**
 * Store FAQ items collected from shortcode output.
 */
function rbd_faq_schema_add_items( $items ) {
    global $rbd_faq_schema_items;

    if ( empty( $items ) || ! is_array( $items ) ) {
        return;
    }

    foreach ( $items as $item ) {
        if ( empty( $item['question'] ) || empty( $item['answer'] ) ) {
            continue;
        }

        $rbd_faq_schema_items[] = array(
            'question' => wp_strip_all_tags( $item['question'] ),
            'answer'   => wp_strip_all_tags( $item['answer'] ),
        );
    }
}

/**
 * Print FAQPage schema only if shortcode collected items on this request.
 */
function rbd_faq_schema_output() {
    if ( is_admin() ) {
        return;
    }

    global $rbd_faq_schema_items;

    if ( empty( $rbd_faq_schema_items ) || ! is_array( $rbd_faq_schema_items ) ) {
        return;
    }

    // De-duplicate by question+answer pair.
    $unique = array();
    foreach ( $rbd_faq_schema_items as $item ) {
        $key = md5( $item['question'] . '|' . $item['answer'] );
        $unique[ $key ] = $item;
    }

    $entities = array();
    foreach ( $unique as $item ) {
        $entities[] = array(
            '@type' => 'Question',
            'name'  => $item['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $item['answer'],
            ),
        );
    }

    if ( empty( $entities ) ) {
        return;
    }

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_values( $entities ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
}
add_action( 'wp_footer', 'rbd_faq_schema_output', 99 );
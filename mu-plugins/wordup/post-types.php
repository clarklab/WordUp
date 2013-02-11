<?php

add_action( 'init', 'register_cpt_session' );

function register_cpt_session() {

    $labels = array( 
        'name' => _x( 'Sessions', 'session' ),
        'singular_name' => _x( 'Session', 'session' ),
        'add_new' => _x( 'Add New', 'session' ),
        'add_new_item' => _x( 'Add New Session', 'session' ),
        'edit_item' => _x( 'Edit Session', 'session' ),
        'new_item' => _x( 'New Session', 'session' ),
        'view_item' => _x( 'View Session', 'session' ),
        'search_items' => _x( 'Search Sessions', 'session' ),
        'not_found' => _x( 'No sessions found', 'session' ),
        'not_found_in_trash' => _x( 'No sessions found in Trash', 'session' ),
        'parent_item_colon' => _x( 'Parent Session:', 'session' ),
        'menu_name' => _x( 'Sessions', 'session' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'comments', 'page-attributes' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => '#',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'page'
    );

    register_post_type( 'session', $args );
}

?>
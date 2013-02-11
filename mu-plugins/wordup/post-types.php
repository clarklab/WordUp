<?php

add_action( 'init', 'register_cpt' );

function register_cpt() {

    $session_labels = array( 
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

    $session_args = array( 
        'labels' => $session_labels,
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

    register_post_type( 'session', $session_args );

    $wordup_labels = array( 
        'name' => _x( 'WordUp', 'wordup' ),
        'singular_name' => _x( 'WordUp', 'wordup' ),
        'add_new' => _x( 'Add New', 'wordup' ),
        'add_new_item' => _x( 'Add New WordUp', 'wordup' ),
        'edit_item' => _x( 'Edit WordUp', 'wordup' ),
        'new_item' => _x( 'New WordUp', 'wordup' ),
        'view_item' => _x( 'View WordUp', 'wordup' ),
        'search_items' => _x( 'Search WordUp', 'wordup' ),
        'not_found' => _x( 'No WordUps found', 'wordup' ),
        'not_found_in_trash' => _x( 'No WordUps found in Trash', 'wordup' ),
        'parent_item_colon' => _x( 'Parent WordUp:', 'wordup' ),
        'menu_name' => _x( 'WordUps', 'wordup' ),
    );

    $wordup_args = array( 
        'labels' => $wordup_labels,
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

    register_post_type( 'wordup', $wordup_args );
}

?>
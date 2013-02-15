<?php

/* Page Slug Body Class */
function add_slug_body_class( $classes ) {
  global $post; if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;}
  return $classes;}

add_filter( 'body_class', 'add_slug_body_class' );

/* Change the 'author' base for all users */
function new_author_base() {
    global $wp_rewrite;
    $author_slug = 'person';
    $wp_rewrite->author_base = $author_slug;
}

add_action('init', 'new_author_base');

function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'sessions_to_wordups',
		'from' => 'session',
		'to' => 'wordup'
	) );
}
add_action( 'p2p_init', 'my_connection_types' );

?>

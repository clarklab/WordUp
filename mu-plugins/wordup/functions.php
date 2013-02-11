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

?>

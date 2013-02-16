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
      p2p_register_connection_type( array(
            'name' => 'rsvps',
            'from' => 'session',
            'to' => 'user'
        ) );
}
add_action( 'p2p_init', 'my_connection_types' );

function get_rsvp_total($postid) {
  $rsvps= get_users( array( 'connected_type' => 'rsvps', 'connected_items' => $postid) );
  return count($rsvps);
}

function get_rsvp_facepile($postid) {
  global $post;
  $rsvps= get_users( array( 'connected_type' => 'rsvps', 'connected_items' => $postid) );
  foreach ($rsvps as $user) {
    $output .='<li><a href="/person/'.$user->user_login.'">'.get_avatar( $user->user_email, '96' ).'</a></li>';}
  return $output;
}
?>

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
		'to' => 'wordup',
             'admin_dropdown' => 'from'
	) );
      p2p_register_connection_type( array(
            'name' => 'session_rsvps',
            'from' => 'session',
            'to' => 'user'
        ) );
      p2p_register_connection_type( array(
            'name' => 'wordup_rsvps',
            'from' => 'wordup',
            'to' => 'user'
        ) );
}
add_action( 'p2p_init', 'my_connection_types' );

function get_rsvp_total($postid) {
  $type = get_post_type( $postid );
  if ($type == 'session') {
  $rsvps = get_users( array( 'connected_type' => 'session_rsvps', 'connected_items' => $postid) );
  } elseif ($type == 'wordup'){
  $rsvps = get_users( array( 'connected_type' => 'wordup_rsvps', 'connected_items' => $postid) );
  }
  return count($rsvps);
}

function get_rsvp_facepile($postid) {
  $type = get_post_type( $postid );
  if ($type == 'session') {
    $rsvps= get_users( array( 'connected_type' => 'session_rsvps', 'connected_items' => $postid) );
  } elseif ($type == 'wordup'){
    $rsvps= get_users( array( 'connected_type' => 'wordup_rsvps', 'connected_items' => $postid) );
  }
  foreach ($rsvps as $user) {
    $output .='<li><a href="/person/'.$user->user_login.'">'.get_avatar( $user->user_email, '96' ).'</a></li>';}
  return $output;
}

add_action( 'pre_get_posts', 'get_closest_wordup' );
function get_closest_wordup( $query ) {
  
  if( $query->is_main_query() && $query->is_home() ) {
    $query->set( 'posts_per_page', '1' );
    $query->set( 'post_type', 'wordup' );
    $query->set( 'meta_key', 'date' );
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'order', 'ASC' );
  }
 
}
?>

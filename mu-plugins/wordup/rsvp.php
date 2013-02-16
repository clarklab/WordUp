<?php

class wordup_session_rsvp {

	function __construct()
	{
		$this->hooks();
	}
	
	function hooks()
	{
		add_action( 'wp_head', array( $this, 'js' ) );
		add_action( 'wp_ajax_rsvp', array( $this, 'handle_rsvp' ) );
	}
	
	function js()
	{
		wp_enqueue_script( 'jquery' );
		wp_print_scripts();
		?>
		<script>
		jQuery(document).ready(function(){
			
			jQuery('#rsvp').click(function(){
				var session_id = jQuery('#session_id').val();
				var rsvp_user_id = jQuery('#rsvp_user_id').val();
			
				jQuery.post(
					'<?php echo get_option('siteurl') . '/wp-admin/admin-ajax.php' ?>',
					{
						action		: 'rsvp',
						user_id		: rsvp_user_id,
						post_id		: session_id,
						_wpnonce	: '<?php echo wp_create_nonce('nonce-rsvp'); ?>',
					},
					function(response) {	
						var data = jQuery.parseJSON(response);
						jQuery("#rsvp").val(data.status + ' the session');
						jQuery('ul.people').html(data.people);
					
					}
				);
				
			});

		});
		</script>
		<?php
	}

	function details()
	{
		
		
		global $current_user;

		$people = get_post_meta(get_the_ID(), 'user', false); 
		if (in_array($current_user->ID, $people)) { $action = 'leave'; } else { $action = 'join'; };

		if( is_user_logged_in() ) {
		$output = '<form action="" method="post">
		<input type="hidden" name="session_id" id="session_id" value="' . get_the_ID() .'">
		<input type="hidden" name="rsvp_user_id" id="rsvp_user_id" value="' . $current_user->ID . '">
		<input type="button" name="rsvp" id="rsvp" value="'.$action.' this session" />
		</form>'; }

		$output .='<ul class="people">';

		$rsvps= get_users( array( 'connected_type' => 'rsvps', 'connected_items' => get_the_ID()) ); 

		foreach ($rsvps as $user) {
		$output .='<li><a href="/person/'.$user->user_login.'">'.get_avatar( $user->user_email, '96' ).'</a></li>';}
		$output .='</ul>';

		return $output;
	}
	
	function handle_rsvp()
	{
		global $wpdb;
		$user_id = (int) $_POST['user_id'];
		$post_id = (int) $_POST['post_id'];
		
		if( !is_user_logged_in() )
			return false;
		
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'nonce-rsvp' ) )
			die( 'Go away, asshole!' );

		$p2p_id = p2p_type( 'rsvps' )->get_p2p_id( $post_id, $user_id );

		if ( $p2p_id ) {
			p2p_type( 'rsvps' )->disconnect( $post_id, $user_id );
			$status = 'left'; 
		} else {
			p2p_type( 'rsvps' )->connect( $post_id, $user_id, array('date' => current_time('mysql')) );
			$status = 'joined';
		}

		$rsvps= get_users( array( 'connected_type' => 'rsvps', 'connected_items' => get_the_ID()) ); 
		if ($rsvps){
		foreach ($rsvps as $user) {
		$facepile.='<li><a href="/person/'.$user->user_login.'">'.get_avatar( $user->user_email, '96' ).'</a></li>';
		} } 

		$return = array('status' => $status, 'people' => $facepile);
		echo json_encode($return);
		
		exit;
	}
}

$rsvp = new wordup_session_rsvp;

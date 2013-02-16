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
			
			jQuery('input.rsvp').click(function(){
				var this_button = jQuery(this);
				var session_id = jQuery(this).closest('form').children('.session_id').val();
				var rsvp_user_id = jQuery(this).closest('form').children('.rsvp_user_id').val();
			
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
						jQuery(this_button).val(data.status + ' the session');
						jQuery(this_button).closest('header').children('.facepile').html(data.facepile);
					
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

		$p2p_id = p2p_type( 'rsvps' )->get_p2p_id( get_the_ID(), $current_user->ID );
		if ( $p2p_id ) {$status = 'leave'; } else { $status = 'join'; };

		if( is_user_logged_in() ) {
		$output = '<form action="" method="post" class="rsvp">
		<input type="hidden" name="session_id" class="session_id" id="session_id" value="' . get_the_ID() .'">
		<input type="hidden" name="rsvp_user_id" class="rsvp_user_id" id="rsvp_user_id" value="' . $current_user->ID . '">
		<input type="button" name="rsvp" id="rsvp" class="rsvp" value="'.$status.' this session" />
		</form>'; }

		$output .='<div class="facepile">';
		$output .='<p class="rsvps"><span class="count">'.get_rsvp_total(get_the_ID()).'</span> Attending</p>';
		$output .='<ul>';
		$output .= get_rsvp_facepile(get_the_ID());
		$output .='</ul>';
		$output .='</div>';

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

		$output .='<p class="rsvps"><span class="count">'.get_rsvp_total($post_id).'</span> Attending</p>';
		$output .='<ul>';
		$output .= get_rsvp_facepile($post_id);
		$output .='</ul>';

		$return = array('status' => $status, 'facepile' => $output);
		echo json_encode($return);
		
		exit;
	}
}

$rsvp = new wordup_session_rsvp;

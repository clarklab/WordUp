<?php
/*
Plugin Name: RSVP
*/


class wordup_session_rsvp {

	function __construct()
	{
		$this->hooks();
	}
	
	function hooks()
	{
		add_action( 'wp_head', array( $this, 'js' ) );
		add_action( 'wp_ajax_join_session', array( $this, 'handle_join_session' ) );
	}
	
	function js()
	{
		wp_enqueue_script( 'jquery' );
		wp_print_scripts();
		?>
		<script>
		jQuery(document).ready(function(){
			
			jQuery('#join_this_session').click(function(){
				var session_id = jQuery('#session_id').val();
				var joining_user_id = jQuery('#joining_user_id').val();
			
				jQuery.post(
					'<?php echo get_option('siteurl') . '/wp-admin/admin-ajax.php' ?>',
					{
						action		: 'join_session',
						user_id		: joining_user_id,
						post_id		: session_id,
						_wpnonce	: '<?php echo wp_create_nonce('nonce-join_session'); ?>',
					},
					function(response) {	
						var data = jQuery.parseJSON(response);
						jQuery("#join_this_session").val(data.status + ' the session');
						jQuery('ul.people').html(data.people);
					
					}
				);
				
			});

		});
		</script>
		<?php
	}

	
	
	function join_session()
	{
		if( !is_user_logged_in() )
			return false;
		
		global $current_user;

		$people = get_post_meta(get_the_ID(), 'user', false); 
		if (in_array($current_user->ID, $people)) { $action = 'leave'; } else { $action = 'join'; };

		$output = '<form action="" method="post">
			<input type="hidden" name="session_id" id="session_id" value="' . get_the_ID() .'">
			<input type="hidden" name="joining_user_id" id="joining_user_id" value="' . $current_user->ID . '">
			<input type="button" name="join_this_session" id="join_this_session" value="'.$action.' this session" />
			</form><ul class="people">';

		
		if ($people){
			foreach ($people as $person) {
			$output .='<a href="#">'.get_avatar( $person, $size = '96' ).'</a>';
			} }
		$output .='</ul>';

		return $output;
	}
	
	function handle_join_session()
	{
		global $wpdb;
		$user_id = (int) $_POST['user_id'];
		$post_id = (int) $_POST['post_id'];
		
		if( !is_user_logged_in() )
			return false;
		
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'nonce-join_session' ) )
			die( 'Go away, asshole!' );
		
		$people = get_post_meta($post_id, 'user', false); 
		if (in_array($user_id, $people)) {
			delete_post_meta( $post_id, 'user', $user_id );
			$status = 'left';
		} else {
			$meta_id = add_post_meta( $post_id, 'user', $user_id );
			$status = 'joined';
		};

		$people = get_post_meta($post_id, 'user', false); 
		if ($people){
		foreach ($people as $person) {
		$list = $list.'<a href="#">'.get_avatar( $person, $size = '96' ).'</a>';
		} } 


		$arr = array('status' => $status, 'people' => $list);

echo json_encode($arr);

				
		exit;
	}
}

$rsvp = new wordup_session_rsvp;

<?php
/**
 * @package WordUp
 * @since WordUp 1.0
 */
?>

<script>
jQuery(document).ready(function() {
jQuery(function () {
    var tabContainers = jQuery('div#tab-container > div');

    jQuery('#wordup-banner nav a').click(function () {
        tabContainers.hide().filter(this.hash).show();
        jQuery('#wordup-banner nav a').removeClass('selected');
        jQuery(this).addClass('selected');
        
        return false;
    }).filter(':first').click();
});
jQuery('#wordup-banner nav').waypoint('sticky');
});
</script>

<div id="wordup-banner" <?php post_class(); ?>>
	
<?php $wordupid= $post->ID; echo get_the_post_thumbnail( $post->ID, 'original') ?>
	
	<div class="entry-content wordup-desc">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wordup' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<nav>
		<ul>
			<li><a href="#sessions">Sessions</a></li>
			<li><a href="#speakers">Speakers</a></li>
			<li><a href="#details">Details</a></li>
		</ul>
	</nav>

</div>

<div id="tab-container">
	
	<?php

	$connected = new WP_Query( array(
	  'connected_type' => 'sessions_to_wordups',
	  'connected_items' => $post->ID,
	  'nopaging' => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :
	?>

	<div id="sessions">
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php get_template_part( 'content', 'session' ) ?>
	<?php endwhile; ?>

	<?php wp_reset_postdata(); endif; ?>

	</div>

	<div id="speakers">
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php get_template_part( 'credit') ?>
	<?php endwhile; ?>
	</div>

	<div id="details">
		Details coming soon!
	</div>

</div>
	


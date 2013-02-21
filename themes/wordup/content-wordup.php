<?php
/**
 * @package WordUp
 * @since WordUp 1.0
 */
?>

<div id="wordup-banner" <?php post_class(); ?> style="background-color:<?php echo get_post_meta( $post->ID, 'banner_color', true )?>">
	
<?php echo get_the_post_thumbnail( $post->ID, 'original') ?>
	
	<div class="entry-content wordup-desc">
		<?php the_excerpt(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<nav>
		<ul>
			
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

	<div id="sessions" class="section" rel="Sessions">
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php get_template_part( 'content', 'session' ) ?>
	<?php endwhile; ?>

	<?php wp_reset_postdata(); endif; ?>

	</div>

	<div id="speakers" class="section" rel="Speakers">
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php get_template_part( 'credit', 'large') ?>
	<?php endwhile; ?>
	</div>

	<?php wp_reset_query(); ?>

	<div id="details" class="section" rel="Details">
		<?php the_content() ?>
	</div>

</div>
	


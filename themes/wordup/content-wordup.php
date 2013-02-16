<?php
/**
 * @package WordUp
 * @since WordUp 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<h2 class="wordup-date"><?php $date = DateTime::createFromFormat('Ymd', get_post_meta($post->ID, 'date', true)); echo $date->format('M j, Y'); ?></h2>
		<h2 class="wordup-time"><?php echo get_post_meta($post->ID, 'time', true); ?></h2>
		<h2 class="wordup-seats">
			<?php $seats = get_post_meta($post->ID, 'space', true); $taken = get_rsvp_total($post->ID); echo ($seats-$taken).' / '; echo $seats; ?> Seats Available
		</h2>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wordup_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	
	<div class="entry-content wordup-desc">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wordup' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	
	<?php

	$connected = new WP_Query( array(
	  'connected_type' => 'sessions_to_wordups',
	  'connected_items' => $post->ID,
	  'nopaging' => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :
	?>

	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<?php get_template_part( 'content', 'session' ) ?>
	<?php endwhile; ?>

	<?php 
	// Prevent weirdness
	wp_reset_postdata();

	endif;
	?>

	
</article><!-- #post-<?php the_ID(); ?> -->

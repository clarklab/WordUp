<?php
/**
 * @package WordUp
 * @since WordUp 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wordup' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wordup_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	<?php global $rsvp; echo $rsvp->details() ?>		

	</header><!-- .entry-header -->

	
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wordup' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
		<?php get_template_part( 'credit') ?>
	</div><!-- .entry-content -->
	
	<?php if (!is_singular( 'wordup' )) {

	$connected = new WP_Query( array(
	  'connected_type' => 'sessions_to_wordups',
	  'connected_items' => get_queried_object(),
	  'nopaging' => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :
	?>

	<ul class="presented">
	<li>Presented at:</li>
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
	</ul>

	<?php 
	// Prevent weirdness
	wp_reset_postdata();

	endif;
	}
	?>

	<footer class="entry-meta">

	
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

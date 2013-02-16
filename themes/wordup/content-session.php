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

		<p class="rsvps"><?php echo get_rsvp_total(); ?> Attending</p>

	</header><!-- .entry-header -->

	
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wordup' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php global $rsvp; echo $rsvp->details() ?>
	
	<?php

	$connected = new WP_Query( array(
	  'connected_type' => 'sessions_to_wordups',
	  'connected_items' => get_queried_object(),
	  'nopaging' => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :
	?>
	<h3>Presented at:</h3>
	<ul>
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
	</ul>

	<?php 
	// Prevent weirdness
	wp_reset_postdata();

	endif;
	?>

	<footer class="entry-meta">

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wordup' ), __( '1 Comment', 'wordup' ), __( '% Comments', 'wordup' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'wordup' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

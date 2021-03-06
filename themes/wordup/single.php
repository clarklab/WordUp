<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordUp
 * @since WordUp 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_type()); ?>

				<?php if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>
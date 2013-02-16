<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordUp
 * @since WordUp 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php

			$wordups = new WP_Query('posts_per_page=1&post_type=wordup&meta_key=date&orderby=meta_value_num&order=ASC');
			p2p_type( 'sessions_to_wordups' )->each_connected( $wordups );

			while ($wordups->have_posts()) : $wordups->the_post(); ?>

			<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<h2 class="wordup-date"><?php $date = DateTime::createFromFormat('Ymd', get_post_meta($post->ID, 'date', true)); echo $date->format('M d, Y'); ?></h2>
			<h2 class="wordup-seats"><?php echo get_post_meta($post->ID, 'space', true); ?> Seats Available</h2>
			</header>

			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wordup' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wordup' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<?php if ($post->connected) { ?>
			
			<?php foreach ( $post->connected as $post ) : setup_postdata( $post ); ?>

			<?php get_template_part( 'content', 'session' ) ?>
		
			<?php endforeach; wp_reset_postdata(); ?>
			
			<?php } ?>

			     <?php 
			  endwhile; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>
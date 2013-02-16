<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordUp
 * @since WordUp 1.0
 */

get_header(); ?>

		<section id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php $user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

				<header>
					<h1 class="entry-title">
						<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
					</h1>
				</header><!-- .page-header -->

				<?php $leading = new WP_Query('post_type=session&author='.$user->ID);
					if ($leading->have_posts()) : ?>
						<ul class="leading">
							 <li>Leading Sessions</li>
							 <?php while ($leading->have_posts()) : $leading->the_post();
							 echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
							 $exclude[]=$post->ID;
							 endwhile; ?>
						</ul>
				<?php endif; ?>

				<?php
				$sessions = get_posts( array(
				  'connected_type' => 'session_rsvps',
				  'connected_items' => $user->ID,
				  'suppress_filters' => false,
				  'nopaging' => true
				) );
				if ($sessions) {?>
				<ul class="joining">
				<li>Also Joining</li>
				<?php foreach ($sessions as $post) {
					setup_postdata( $post );
					if (in_array($post->ID, $exclude)) { } else {
				    echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';}
				wp_reset_postdata();
				} ?>
				</ul> 
				 <?php } ?>
				

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

<?php get_footer(); ?>
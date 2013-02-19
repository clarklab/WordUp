<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordUp
 * @since WordUp 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="//use.typekit.net/wnx2sbz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">

	<?php
	global $wordups;
	$wordups = new WP_Query('posts_per_page=1&post_type=wordup&meta_key=date&orderby=meta_value_num&order=ASC'); 
	 while ($wordups->have_posts()) : $wordups->the_post(); ?>

		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php the_title(); ?></a></h1>
			<?php $tagline = get_post_meta($post->ID, 'tagline', true); if ($tagline) { ?>
			<h2 class="wordup-details">
			<span class="date"><?php $date = DateTime::createFromFormat('Ymd', get_post_meta($post->ID, 'date', true)); echo $date->format('M j, Y'); ?></span> 
			<span class="time"><?php echo get_post_meta($post->ID, 'time', true); ?></span>
			</h2>
			<?php } ?>
		</hgroup>

		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="assistive-text"><?php _e( 'Menu', 'wordup' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'wordup' ); ?>"><?php _e( 'Skip to content', 'wordup' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->

		
		<h2 class="wordup-seats">
			<?php $seats = get_post_meta($post->ID, 'space', true); $taken = get_rsvp_total($post->ID); echo ($seats-$taken).' / '; echo $seats; ?> Seats Available
		</h2>

		<div class="facepile">
		<ul>
		<?php echo get_rsvp_facepile($post->ID); ?><?php echo str_repeat('<li class="placeholder"><a href=""><img src="'.get_bloginfo( 'template_directory' ).'/images/avatar-generic.png"/></a></li>', ($seats-$taken)); ?>
		</ul>
		</div>
		
	<?php endwhile; ?>

	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main">

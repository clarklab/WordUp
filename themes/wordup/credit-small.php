<div class="speaker speaker-small">

<?php echo get_avatar( get_the_author_meta('user_email'), 96 ); ?>

<h2>Session Leader: <a href="/person/<?php the_author_meta('user_login'); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a></h2>
<p><?php the_author_description(); ?></p>

</div>
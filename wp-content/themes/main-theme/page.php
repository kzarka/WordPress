<?php
/**
 * The template for displaying all pages
 *
 */
get_header();

if (is_front_page()): ?>
<main id="main" class="site-main common-home" role="main">
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>
</main>

<?php
else:
?>
<div class="container">
	<?php
	while ( have_posts() ) : the_post();
		the_content();

	endwhile; 
	?>
</div>
<?php
endif;

get_footer();

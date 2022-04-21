<?php
/**
 * The template for displaying search results pages
 *
 */

get_header();
?>
<div id="content" class="site-content">
	<div class="container">
<main id="main" class="site-main" role="main">

	<?php 
	if ( have_posts() ) : ?>

		<header class="page-header">
			<h1>Results: <?php echo get_search_query(); ?></h1>
		</header>
				<div class="row">
					<div class="col-order">
						<?php renderTemplate('pages/blog/archive'); ?>
						<?php renderTemplate('sidebars/blog'); ?>
					</div>
				</div>
		<?php
	
	else: ?>

		<p>Sorry, but nothing matched your search terms.</p>
	
	<?php
	endif;
	?>

</main>
</div>
</div>
<?php
get_footer();
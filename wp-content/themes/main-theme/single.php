<?php
/**
 * The template for displaying all single posts
 *
 */

get_header();
?>

<div class="container">
	<?php renderTemplate('layouts/blog/content'); ?>
</div><!-- #container -->

<?php
get_footer();
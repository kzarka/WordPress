<?php
/**
 * Template part for displaying posts
 */

?>

<article id="post-<?php the_ID(); ?>" class="entry">
	<header class="entry-header">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="article-date"> by: elomus-theme Admin - <time datetime="<?= get_the_date() ?>"> <?= get_the_date('Y/m/d') ?> </time></div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
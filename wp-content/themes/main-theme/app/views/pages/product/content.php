<?php while ( have_posts() ) : the_post(); ?>
<?php renderTemplate('pages/product/partials/product-info'); ?>
<?php renderTemplate('pages/product/partials/product-desc'); ?>
<?php endwhile; ?>
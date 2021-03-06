<?php
/*
  Template name: Nasa View compare
  This templates View products in compare.
 */
global $yith_woocompare;
if(!$yith_woocompare) :
    wp_redirect(esc_url(home_url('/')));
endif;

get_header(); ?>

<div class="page-wrapper nasa-view-compare">
    <div class="row">
        <div id="content" class="large-12 columns">
            <!-- Compare products -->
            <?php
            echo flozen_products_compare_content();
            
            while (have_posts()) :
                the_post();
                the_content();
            endwhile; // end of the loop.
            ?>
        </div><!-- end #content large-12 -->
    </div><!-- end row -->
</div><!-- end page-right-sidebar container -->
<?php
get_footer();

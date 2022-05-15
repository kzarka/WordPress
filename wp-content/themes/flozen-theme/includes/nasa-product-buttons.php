<?php
/*
 * Product group button
 */
?>
<div class="product-interactions">
    <?php do_action('nasa_before_show_buttons_loop'); // before loop btn ?>
    <?php do_action('nasa_show_buttons_loop'); // loop btn ?>
    <?php do_action('nasa_after_show_buttons_loop'); // after loop btn ?>
</div>
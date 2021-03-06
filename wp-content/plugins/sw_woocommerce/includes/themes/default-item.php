<?php 

/**
* Layout Theme Car
* @version     1.0.0
**/
?>
<div class="item-wrap">
	<div class="item-detail">										
		<div class="item-img products-thumb">		
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		</div>										
		<div class="item-content">																			
			<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
			<?php if ( $price_html = $product->get_price_html() ){?>
			<div class="item-price">
				<span>
					<?php echo $price_html; ?>
				</span>
			</div>
			<?php } ?>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>								
	</div>
</div>
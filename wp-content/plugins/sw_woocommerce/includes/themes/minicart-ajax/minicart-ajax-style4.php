<?php 
if ( !class_exists( 'WooCommerce' ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="top-form top-form-minicart autusin-minicart4 pull-right">
	<div class="top-minicart-icon pull-right">
		<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e('View your shopping cart', 'autusin'); ?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>';?></a>
		<div class="cart-title"><h3><?php esc_html_e('Your Cart: ','autusin');?><?php echo $woocommerce->cart->get_cart_total(); ?></h3></div>
	</div>
	<div class="wrapp-minicart">
		<div class="minicart-padding">
			<div class="number-item"><?php echo sprintf( __('There are <span class="item">%d item(s)</span> in your cart','autusin'), $woocommerce->cart->cart_contents_count ); ?></div>
			<ul class="minicart-content">
				<?php 
					foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item): 
					$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_name = ( sw_woocommerce_version_check( '3.0' ) ) ? $_product->get_name() : $_product->get_title();
				?>
					<li>
						<a href="<?php echo get_permalink($cart_item['product_id']); ?>" class="product-image">
							<?php echo ( $_product->get_image( 'thumbnail' ) ); ?>
						</a>
						<?php 	global $product, $post, $wpdb, $average; ?>
						<div class="detail-item">
							<div class="product-details"> 
								<h4><a class="title-item" href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo esc_html( $product_name ); ?></a></h4>	  		
								<div class="product-price">
									<span class="price"><?php echo ( $woocommerce->cart->get_product_subtotal($cart_item['data'], 1) ); ?></span>	      
									<div class="qty">
										<?php echo '<span class="qty-number">'.esc_html( $cart_item['quantity'] ).'</span>'; ?>
									</div>
								</div>
								<div class="product-action clearfix">
									<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="btn-remove" title="%s"><span class="fa fa-trash-o"></span></a>', esc_url( ( sw_woocommerce_version_check( '3.3' ) ) ? wc_get_cart_remove_url( $cart_item_key ) : $woocommerce->cart->get_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'autusin' ) ), $cart_item_key ); ?>           
									<a class="btn-edit" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'autusin'); ?>"><i class="fa fa-pencil"></i><span></span></a>    
								</div>
							</div>	
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="cart-checkout">
			    <div class="price-total">
				   <span class="label-price-total"><?php esc_html_e('Subtotal:', 'autusin'); ?></span>
				   <span class="price-total-w"><span class="price"><?php echo ( $woocommerce->cart->get_cart_subtotal() ); ?></span></span>			
				</div>
				<div class="cart-links clearfix">
					<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="<?php esc_attr_e( 'Cart', 'autusin' ) ?>"><?php esc_html_e('View Cart', 'autusin'); ?></a></div>
					<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="<?php esc_attr_e( 'Check Out', 'autusin' ) ?>"><?php esc_html_e('Check Out', 'autusin'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
/**
	* Layout Bunled product Default
	* @version     1.0.0
**/
//echo "da vao";
$viewall = get_permalink( wc_get_page_id( 'shop' ) );
$term_name = esc_html__( 'All Categories', 'sw_woocommerce' );
$default = array(
	'post_type' => 'product',	
	'orderby' => $orderby,
	'order' => $order,
	'post_status' => 'publish',
	'showposts' => $numberposts	
);
$default['tax_query'][] = array(						
		'taxonomy' => 'product_type',
		'field'    => 'name',
		'terms'    => 'bundle',
		'operator' => 'IN',	
	);
//var_dump($category);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );
	if( $term ) :
		$term_name = $term->name;
	endif; 
	
	$default['tax_query'][] = array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ));
}
$id = 'sw_countdown_'.$this->generateID();
$list = new WP_Query( $default );

if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $category.'_'.$id; ?>" class="sw-woo-container-slider responsive-slider bundle-slider loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-circle="false" data-dots="false">
		<?php if( $title1 != '' ){?>
			<div class="box-title">
				<h3><span><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></span></h3>
			</div>
		<?php } ?>
		<div class="resp-slider-container">
			<div class="slider responsive">	
			<?php 
				$count_items = 0;
				$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();					
				global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
				if( $i % $item_row == 0 ){
			?>
				<div class="item-countdown item-product-bund product-images <?php echo esc_attr( $class )?>" id="<?php echo 'product_'.$id.$post->ID; ?>" data-vertical="false">
				<?php } ?>
					<div class="item-wrap">
						<div class="item-detail">
							<div class="item-top-product">							
								<div class="item-image-bundle products-thumb-big products-thumb">
								    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php 
										$id = get_the_ID();
										if ( has_post_thumbnail() ){
											echo get_the_post_thumbnail( $post->ID, 'shop_single' ) ? get_the_post_thumbnail( $post->ID, 'shop_single' ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'shop_single'.'.png" alt="No thumb">';		
										}else{
											echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'shop_single'.'.png" alt="No thumb">';
										}
										?>
									</a>
									<?php echo sw_label_sales(); ?>
								</div>
								<div class="item-content">
									<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
								    <!-- rating  --> <?php if (  wc_review_ratings_enabled() ) { ?>
									<?php 
										$rating_count = $product->get_rating_count();
										$average      = $product->get_average_rating();
									?>
									<div class="reviews-content">
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*12 ).'px"></span>' : ''; ?></div>
									</div>									
									<?php } ?><!-- end rating  -->
									<!-- Price -->
									<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
									<?php } ?>
									 <!-- add to cart, wishlist, compare -->
									<div class="item-bottom clearfix">
										<?php woocommerce_template_loop_add_to_cart(); ?>											
									</div>			
								</div>	
							</div>
							<!--- pack thumail -->
						    <div class="item-pack">
								<div class="product-responsive-pack" id="product_thumbnail_<?php echo esc_attr( $post->ID ); ?>">											 
									<?php	
									    $bundles = apply_filters( 'swpb/load/bundle', $product->get_id() );
										foreach ( $bundles as $key => $value )  { 
                                        $bundle = wc_get_product( $key ); 
										if( !is_wp_error( $bundle ) && $bundle ){
                                        $product_url = "";
                                        if ( get_post_type( $key ) == 'product_variation' ) {
											$product_url = get_the_permalink( wp_get_post_parent_id( $key ) );
										} else {
											$product_url = get_the_permalink( $key );
										}
									?>
									<div class="boxinfo-wrapper">
										<div class="boxinfo-box">
											<div class="thumbnail-wrapper">
												<?php echo $bundle->get_image( 'shop_catalog' ); ?>
											</div>
											<div class="boxinfo-bot">
												<h3><a href="<?php echo esc_url( $product_url ); ?>"><?php echo esc_html( $value['title'] );?></a></h3>
		                                        <div class="item-price"><?php echo $bundle->get_price_html();?></div>
											</div>
										</div>
                                    </div>
										<?php } } ?> 
								</div>	
							</div>	
							<!-- end pack thumnail -->			
						</div>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php }?>
			<?php $i ++; endwhile; wp_reset_postdata();?>
			</div>
		</div>            
	</div>
<?php
	} 
?>
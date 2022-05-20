<?php 
	$widget_id =  'sw_woo_tab_'. $this->generateID();
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	if( $category != '' ){
		$term = get_term_by( 'slug', $category, 'product_cat' );
		if( $term ) :
			$term_name = $term->name;
			$viewall = get_term_link( $term->term_id, 'product_cat' );
		endif;
	}

?>
<div class="sw-wootab-slider sw-ajax sw-woo-tab-style10" id="<?php echo esc_attr( $widget_id ); ?>" >					
	<div class="resp-tab" style="position:relative;">
		<div class="box-title">
			<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h3>'. $title .'</h3>';
			?>
			<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
		</div>
		<div class="top-tab-slider ">
		<button class="button-collapse collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo 'nav_'.$widget_id; ?>"  aria-expanded="false">				
		</button>
			<ul class="nav nav-tabs " id="<?php echo 'nav_'.$widget_id; ?>">
				<?php 
					$active = $tab_active -1;
					$tab_title = '';
					foreach( $select_order as $i  => $so ){						
						switch ($so) {
						case 'latest':
							$tab_title = __( 'Latest Products', 'sw_woocommerce' );
						break;
						case 'rating':
							$tab_title = __( 'Top Rating', 'sw_woocommerce' );
						break;
						case 'bestsales':
							$tab_title = __( 'Best Selling', 'sw_woocommerce' );
						break;						
						default:
							$tab_title = __( 'Featured Products', 'sw_woocommerce' );
						}
					?>
					<li <?php echo ( $i == $active )? 'class="active loaded"' : ''; ?>>
						<a href="#<?php echo esc_attr( str_replace( '%', '', $so ). '_' .$widget_id ) ?>" data-type="so_ajax" data-layout="<?php echo esc_attr( isset( $widget_template ) ? $widget_template : $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( sw_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
					</li>			
				<?php } ?>
			</ul>
		</div>
		<div class="tab-content ">	
			<?php 
			$banner_links = explode( ',', $banner_links );
			if( $img_banners != '' ) :
				$img_banners = explode( ',', $img_banners );	
			endif;
			?>
			<div class="banner-category pull-left">
				<div id="<?php echo esc_attr( 'banner_' . $widget_id ); ?>" class="banner-slider" data-lg="1" data-md="1" data-sm="1" data-xs="1" data-mobile="1" data-arrow="false" data-fade="false">
					<div class="banner-responsive">
						<?php foreach( $img_banners as $key => $img ) : ?>
							<a href="<?php echo esc_url( $banner_links[$key] ); ?>"><?php echo wp_get_attachment_image( $img, 'large' ); ?></a>
						<?php endforeach;?>
					</div>
				</div>									
			</div>
		<!-- Product tab slider -->				
			<div class="tab-pane active" id="<?php echo esc_attr( str_replace( '%', '', $select_order[$active] ). '_' .$widget_id ) ?>">
			<?php 
				$default = array();			
				if( $select_order[$active] == 'latest' ){
					$default = array(
						'post_type'	=> 'product',
						'paged'		=> 1,
						'showposts'	=> $numberposts,
						'orderby'	=> 'date'
					);						
				}
				if( $select_order[$active] == 'rating' ){
					$default = array(
						'post_type'		=> 'product',							
						'post_status' 	=> 'publish',
						'no_found_rows' => 1,					
						'showposts' 	=> $numberposts						
					);
					if( sw_woocommerce_version_check( '3.0' ) ){	
						$default['meta_key'] = '_wc_average_rating';	
						$default['orderby'] = 'meta_value_num';
					}else{	
						add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
					}
				}
				if( $select_order[$active] == 'bestsales' ){
					$default = array(
						'post_type' 			=> 'product',							
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'showposts'				=> $numberposts,
						'meta_key' 		 		=> 'total_sales',
						'orderby' 		 		=> 'meta_value_num'						
					);
				}
				if( $select_order[$active] == 'featured' ){
					$default = array(
						'post_type'	=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'	=> 1,
						'showposts' 		=> $numberposts,						
					);
					if( sw_woocommerce_version_check( '3.0' ) ){	
						$default['tax_query'][] = array(						
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'featured',
							'operator' => 'IN',	
						);
					}else{
						$default['meta_query'] = array(
							array(
								'key' 		=> '_featured',
								'value' 	=> 'yes'
							)					
						);				
					}
				}
				if( $category != '' ){
					$default['tax_query'][] = array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category,
						'operator' 	=> 'IN'
					);
				}
				$default = sw_check_product_visiblity( $default );
				
				$list = new WP_Query( $default );
				if( $select_order[$active] == 'rating' && ! sw_woocommerce_version_check( '3.0' ) ){			
					remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
				}
				if( $list->have_posts() ) :						
			?>
				<div id="<?php echo esc_attr( str_replace( '%', '', 'tab_'.$select_order[$active] ). '_' .$widget_id ) ?>" class="woo-tab-container-slider responsive-slider loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
					<div class="resp-slider">
						<div class="slider-responsive">
						<?php 
							$count_items 	= 0;
							$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
							$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
							$i 				= 0;
							$j				= 0;
							while($list->have_posts()): $list->the_post();
							global $product, $post;	
							$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
							if( $i % $item_row == 0 ){
						?>
							<div class="item <?php echo esc_attr( $class )?> product clearfix">
						<?php } ?>
							<div class="item-wrap4">
								<div class="item-detail">										
									<div class="item-img products-thumb">		
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php 
											$id = get_the_ID();
											if ( has_post_thumbnail() ){
												echo get_the_post_thumbnail( $post->ID, 'medium', array( 'alt' => get_the_title() ) ) ? get_the_post_thumbnail( $post->ID, 'medium', array( 'alt' => get_the_title() ) ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';		
											}else{
												echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';
											}
											?>
										</a>
										<?php sw_label_sales();?>
										<div class="top-item">
										<?php echo autusin_quickview() ;?>
										<?php
										if ( class_exists( 'YITH_WCWL' ) ){
											echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
										} ?>
										</div>	
									</div>										
									<div class="item-content">	
										<!-- rating  --> <?php if (  wc_review_ratings_enabled() ) { ?>
										<?php 
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
										?>
																											
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
										<div class="reviews-content">
											<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
										</div>									
										<?php } ?>
										<!-- end rating  -->
										<!-- price -->
										<?php if ( $price_html = $product->get_price_html() ){?>
										<div class="item-price">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>
										<div class="item-button clearfix">
											<?php echo autusin_addcart() ;?>
										</div>
									</div>
								</div>
							</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>					
			<?php 
				else :
					echo '<div class="alert alert-warning alert-dismissible" role="alert">
					<a class="close" data-dismiss="alert">&times;</a>
					<p>'. esc_html__( 'There is not product on this tab', 'sw_woocommerce' ) .'</p>
					</div>';
				endif;				
			?>
			</div>
		<!-- End product tab slider -->										
		</div>
</div>
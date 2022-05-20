<?php 

/**
	* Layout Best Sales
	* @version     1.0.0
**/


$term_name = esc_html__( 'Most View', 'sw_woocommerce' );
$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
$default = array(
	'post_type' 			=> 'product',		
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'   => 1,
	'showposts'				=> $numberposts,
	'meta_key' 		 		=> 'post_views_count',
	'orderby' 		 		=> 'meta_value_num '. $orderby ,
	'order' => $order,
	
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
		$viewall = get_term_link( $term->term_id, 'product_cat' );
	endif;
	
	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'	=> 'slug',
			'terms'	=> $category,
			'operator' => 'IN'
		)
	);
}
$id = 'sw_bestsales_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider responsive-slider sw-mostviewed2 loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-dots="false">
		<div class="box-title">
			<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h3>'. $title .'</h3>';
			?>
			<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
		</div>
		<div class="resp-slider-container">
			<div class="slider responsive">	
			<?php 
				$count_items 	= 0;
				$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
				$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
				$i 				= 0;
				while($list->have_posts()): $list->the_post();global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
				if( $i % $item_row == 0 ){
			?>
				<div class="item product <?php echo esc_attr( $class )?>">
			<?php } ?>
					<div class="item-inner clearfix">
						<div class="item-thumbnail pull-left">
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
						</div>
						<div class="item-content">
							<h4><a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php sw_trim_words( $post->post_title, $title_length ) ?></a></h4>
			            	<?php if ( $price_html = $product->get_price_html() ){?>
			                <div class="item-price">
			                    <span><?php echo $price_html; ?></span>
			                </div>
		                	<?php } ?>
							<div class="view-more">
								<a href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr( $post->post_title ) ?>"><?php esc_html_e( 'View detail', 'sw_woocommerce' ) ?></a>
							</div>
						</div>
					</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i++; endwhile; wp_reset_postdata();?>
			</div>
		</div>					
	</div>
<?php
}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'There is not product in this category', 'sw_woocommerce' ) .'</p>
	</div>';
	}	
?>
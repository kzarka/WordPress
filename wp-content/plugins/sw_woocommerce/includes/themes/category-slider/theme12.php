<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="responsive-slider sw-category-slider12 loading"  data-append=".resp-slider-container" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<?php	if( $title1 != '' ){ ?>
	<div class="block-title">
		<?php
			$titles = strpos($title1, ' ');
			$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
			echo '<h3>'. $title .'</h3>';
		?>
		<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
	</div>
	<?php } ?>
	
	<div class="resp-slider-container">
		<div class="slider responsive">
		<?php
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
			foreach( $category as $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');	
				if( $term ) :
				$thumbnail_id 	= get_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'medium' );
		?>
			<div class="item item-product-cat">
				<div class="item-inner">
					<div class="item-image">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
					</div>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
						<p><?php echo esc_attr( $term->count ); ?><?php echo esc_html__(' products','sw_woocommerce'); ?></p>
						<a class="view-all" href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html__('view all','sw_woocommerce'); ?> <i class="fa fa-chevron-right"></i></a>
					</div>
				</div>
			</div>
			<?php endif; ?>
		<?php } ?>
		</div>
	</div>
</div>
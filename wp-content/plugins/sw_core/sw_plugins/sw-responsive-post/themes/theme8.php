<?php 
	/**
		** Theme: Responsive Slider
		** Author: Smartaddons
		** Version: 1.0
	**/
	//var_dump($category);
	$default = array(
			'category' => $category, 
			'orderby' => $orderby,
			'order' => $order, 
			'numberposts' => $numberposts,
	);
	$list = get_posts($default);
	do_action( 'before' ); 
	$id = 'sw_reponsive_post_slider_'.rand().time();
	if ( count($list) > 0 ){
?>
<div class="clear"></div>
<div id="<?php echo esc_attr( $id ) ?>" class="responsive-post-slider8 responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<div class="box-title">
		<?php
			$titles = strpos($title2, ' ');
			$title = ($titles !== false) ? '<span>' . substr($title2, 0, $titles) . '</span>' .' '. substr($title2, $titles + 1): $title2 ;
			echo '<h3>'. $title .'</h3>';
		?>
		<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
	</div>
	<div class="resp-slider-container">
		<div class="slider responsive">
			<?php foreach ($list as $post){ ?>
				<?php if($post->post_content != Null) { ?>
				<div class="item widget-pformat-detail">
					<div class="item-inner">					
						<div class="item-detail">
							<?php 
								$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
								if ( $feat_image_url ){ 
								?>
								<div class="img_over">
									<a href="<?php echo get_permalink($post->ID)?>" >
										<?php 								
											$width  = 420;
											$height = 500;
											$crop = isset( $crop ) ? $crop : true;
											$image = sw_image_resize( $feat_image_url, $width, $height, $crop );
											echo '<img src="'. esc_url( $image['url'] ) .'" alt="'. esc_attr( $post->post_title ) .'">';
										?>
									</a>
								</div>
							<?php } ?>
							<div class="entry-content">
								<div class="entry-meta">
									<span class="time-fm"><?php echo get_the_date( '', $post->ID );?></span>
								</div>
								<h4><a href="<?php echo get_permalink($post->ID)?>"><?php echo $post->post_title;?></a></h4>
								<div class="readmore"><a href="<?php echo get_permalink($post->ID)?>"><?php esc_html_e('Read More', 'sw_core'); ?></a> <i class="fa fa-angle-double-right" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			<?php }?>
		</div>
	</div>
</div>
<?php } ?>
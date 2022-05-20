<?php 
	$default = array(
		'post_type' => 'testimonial',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$id = 'sw_testimonial'.rand().time();
	$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="sw_testimonial_<?php echo esc_attr( $id ) ?>" class="responsive-slider testimonial-slider4 loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="box-title">
			<?php
				$titles = strpos($title, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title, 0, $titles) . '</span>' .' '. substr($title, $titles + 1): $title ;
				echo '<h3>'. $title .'</h3>';
			?>
			<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
		</div>
		<div class="resp-slider-container">
			<div class="slider responsive">
			<?php
				$count_items = ($numberposts >= $list->found_posts) ? $list->found_posts : $numberposts;
				$i = 0;
				while($list->have_posts()): $list->the_post();
				global  $post;
				$au_name = get_post_meta( $post->ID, 'au_name', true );
				$au_info = get_post_meta( $post->ID, 'au_info', true );
				$target = get_post_meta( $post->ID, 'target', true );
					if( $i % $item_row == 0 ){
			?>
				<div class="item">
					<?php } ?>
					<div class="item-inner">
						<div class="client-comment">
							<i class="fa fa-quote-left" aria-hidden="true"></i>
							<?php
								$text = get_the_content($post->ID);
								$content = wp_trim_words($text, $length);
								echo esc_html($content);
							?>
						</div>
						<div class="client-content clearfix">
							<?php if(has_post_thumbnail()){ ?>
							<div class="item-img pull-left">
								<?php the_post_thumbnail(); ?>
							</div>
							<?php } ?>
							<div class="reviews-content">
								<div class="star"><span style="width:90px"></span></div>
							</div>
							<div class="au_name"><?php echo esc_html($au_name) ?></div>
							<div class="au_info"><?php echo esc_html($au_info) ?></div>
						</div>
					</div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i ++; endwhile; wp_reset_query();?>
			</div>
		</div>
	</div>
<?php
}
?>
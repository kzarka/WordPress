<?php 
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_testimonial'.rand().time();
$default = array(
	'post_type' => 'testimonial',
	'orderby' => $orderby,
	'order' => $order,
	'post_status' => 'publish',
	'showposts' => $numberposts
	);
$list = new WP_Query( $default );
if ( $list->have_posts() ){
	$i = 0;
	$j = 0;
	$k = 0;
	?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="carousel slide testimonial-slider " data-ride="carousel" data-interval="5000" data-autoplay="true">
		<?php if($title !=''){ ?>
		<div class="block-title <?php echo esc_attr( $style_title ) ?>">
			<h2><span><?php echo $title ?></span></h2>
		</div>
		<?php } ?>
		
		<!-- Indicators -->
		<ol class="carousel-indicators">
		<?php 
				while ( $list->have_posts() ) : $list->the_post();
				if( $j % 1 == 0 ) {  $k++;
					$active = ($j== 0)? 'active' :'';
					?>
					<li class="<?php echo $active ?>" data-slide-to="<?php echo ($k-1) ?>" data-target="#<?php echo esc_attr( $widget_id ) ?>">
						<?php } if( ( $j+1 ) % 1 == 0 || ( $j+1 ) == $numberposts ){ ?>
					</li>
					<?php 
				}					
				$j++; 
				endwhile; 
				wp_reset_postdata(); 
		?>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		<?php 
			while($list->have_posts()): $list->the_post();
			global $post;
			$au_name = get_post_meta( $post->ID, 'au_name', true );
			$au_url  = get_post_meta( $post->ID, 'au_url', true );
			$au_info = get_post_meta( $post->ID, 'au_info', true );
			$active = ($i== 0) ? 'active' :'';
			?>
			<div class="item <?php echo esc_attr( $active ) ?>">
				<div class="item-inner">							
					<div class="client-say-info">
						<div class="image-client">
							<a href="#" title="<?php echo esc_attr( $post->post_title ) ?> "><?php the_post_thumbnail( 'thumbnail' ) ?></a>
						</div>
						<div class="name-client">
							<h2>
							<a href="#" title="<?php echo esc_attr( $post->post_title ) ?>"><?php echo esc_html($au_name) ?></a>
							</h2>
							<?php if($au_info !=''){ ?>
							<div class="info-client"><?php echo esc_html($au_info) ?></div>
							<?php } ?>
						</div>
						<div class="client-comment">
							<?php
							$text = get_the_content($post->ID);	
							$content = wp_trim_words($text, $length);
							echo esc_html($content);
							?>
						</div>
					</div>
				</div>
			</div> 
			<?php $i++; endwhile; wp_reset_postdata();  ?>
		</div>

  <!-- Controls -->
		<div class="carousel-cl nav-custom">
			<a class="prev-test fa fa-caret-left" href="#<?php echo esc_attr( $widget_id ) ?>" role="button" data-slide="prev"></a>
			<a class="next-test fa fa-caret-right" href="#<?php echo esc_attr( $widget_id ) ?>" role="button" data-slide="next"></a>
		</div>	
	</div>
	<?php	
}
?>
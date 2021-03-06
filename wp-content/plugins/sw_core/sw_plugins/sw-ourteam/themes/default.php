<?php 
	$ya_direction = false;
	$default = array(
		'post_type' => 'team',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$widget_id = isset( $widget_id ) ? $widget_id : 'sw_testimonial'.rand().time();
	$list = new WP_Query( $default );
?>
<div id="<?php echo esc_attr( $widget_id ) ?>" class="responsive-slider sw-ourteam-slider default loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<div class="box-title">
		<h2><?php  echo $title; ?></h2>
		<?php echo ( $description != '' ) ? '<div class="description">'. $description .'</div>' : ''; ?>
	</div>
	<?php 
		if ( $list -> have_posts() ){
	?>
	<div class="resp-slider-container">
		<div class="slider responsive">
		<?php 
			$count_items = 0;
			$numb = ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
			$count_items = ( $numberposts >= $numb ) ? $numb : $numberposts;
			$i = 0;
			while($list->have_posts()): $list->the_post();
			global  $post;
			$facebook = get_post_meta( $post->ID, 'facebook', true );	
			$twitter = get_post_meta( $post->ID, 'twitter', true );
			$gplus = get_post_meta( $post->ID, 'gplus', true );
			$linkedin = get_post_meta( $post->ID, 'linkedin', true );
			$team_info = get_post_meta( $post->ID, 'team_info', true );
			if( $i % $item_row == 0 ){
		?>
			<div class="item ">
		<?php } ?>
				<div class="item-wrap">							
				<?php if(has_post_thumbnail()){ ?>
					<div class="item-img item-height">
						<div class="item-img-info">				
							<?php the_post_thumbnail(); ?>
						</div>
					</div>
				<?php } ?>					
					<div class="item-content">
						<h3><?php the_title(); ?></h3>
						<?php if( $team_info != '' ){ ?>
						<div class="team-info"><?php echo esc_html( $team_info ); ?></div>
						<?php } ?>
					</div>
					<?php if( $facebook != '' || $twitter != '' || $gplus != '' || $linkedin != '' ){?>																
						<div class="item-social">
						    	<?php if( $linkedin != '' ){ ?>
							<div class="team-linkedin">
								<a href="<?php echo esc_attr( $linkedin ); ?>"><i class="fa fa-linkedin"></i></a>
							</div>
							<?php } ?>		
							<?php if( $facebook != '' ){ ?>
							<div class="team-facebook">
								<a href="<?php echo esc_attr( $facebook ); ?>"><i class="fa fa-facebook"></i></a>
							</div>
							<?php } ?>
							<?php if( $twitter != '' ){ ?>
							<div class="team-twitter">
								<a href="<?php echo esc_attr( $twitter ); ?>"><i class="fa fa-twitter"></i></a>
							</div>
							<?php } ?>
							<?php if( $gplus != '' ){ ?>
							<div class="team-gplus">
								<a href="<?php echo esc_attr( $gplus ); ?>"><i class="fa fa-google-plus"></i></a>
							</div>
							<?php } ?>
													
						</div>
					<?php } ?>					
				</div>
			<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php $i++; endwhile; wp_reset_postdata();?>
		</div>
	</div>
	<?php }	?>
</div>
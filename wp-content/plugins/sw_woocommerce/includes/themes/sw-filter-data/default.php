<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : 'sw_filter_data_'.$this->generateID();
	$term_filter_datas = array();
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	if( count( $category ) == 1 && $category[0] == 0 ){
		$terms = get_terms( 'product_filter_data', array( 'parent' => '', 'hide_empty' => 0, 'number' => $numberposts ) );
		foreach( $terms as $key => $cat ){
			$term_filter_datas[$key] = $cat -> slug;
		}
	}else{
		$term_filter_datas = $category;
	}
	
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="responsive-slider sw-filter_data-container-slider <?php echo esc_attr( $style ); ?> loading clearfix">
		<?php if( $title1 != '') { ?>
			<?php if( $style == '') {?>
				<div class="title-filter custom-font pull-left" ><?php echo esc_html( $title1 ); ?></div>
			<?php }else{ ?>
				<div class="box-slider-title2"><?php echo ( $title1 != '' ) ? '<h2>'. esc_html( $title1 ) .'</h2>' : ''; ?></div>
			<?php } } ?>
		<?php do_action('add_filter_data'); ?>
	</div>

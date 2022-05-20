<?php
/**
 * SW Woo Tab Slider Widget
 * Plugin URI: http://www.magentech.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
if ( !class_exists('sw_woo_tab_slider_widget') ) {
	class sw_woo_tab_slider_widget extends WP_Widget {
		
		private $snumber = 1;
		
		/**
		 * Widget setup.
		 */
		function __construct() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woo_tab_slider', 'description' => __('Sw Woo Tab Slider', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woo_tab_slider' );

			/* Create the widget. */
			parent::__construct( 'sw_woo_tab_slider', __('Sw Woo Tab Slider widget', 'sw_woocommerce'), $widget_ops, $control_ops );
					
			add_shortcode( 'woo_tab_slider', array( $this, 'SC_WooTab' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
				add_action( 'vc_before_init', array( $this, 'SC_integrateWithVC' ) );
			}
			
			/* Ajax Call */
			if( version_compare( WC()->version, '2.4', '>=' ) ){
					add_action( 'wc_ajax_sw_tab_category', array( $this, 'sw_tab_category_callback' ) );
			}
			else {
				add_action( 'wp_ajax_sw_tab_category', array( $this, 'sw_tab_category_callback') );
				add_action( 'wp_ajax_nopriv_sw_tab_category', array( $this, 'sw_tab_category_callback') );
			}
		}
		
		public function generateID() {
			return $this->id_base . '_' . (int) $this->snumber++;
		}
		
		/**
			* Add Vc Params
		**/
		function SC_integrateWithVC(){
			$terms = get_terms( 'product_cat', array( 'parent' => '', 'hide_empty' => false ) );
			$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
			if( count( $terms )  > 0 ){
				foreach( $terms as $cat ){
					$term[$cat->name] = $cat -> slug;
				}
			}
			vc_map( array(
				"name" => __( "SW Woocommerce Tab Slider", 'sw_woocommerce' ),
				"base" => "woo_tab_slider",
				"icon" => "icon-wpb-ytc",
				"class" => "",
				"category" => __( "SW Shortcodes", 'sw_woocommerce'),
				"params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", 'sw_woocommerce' ),
					"param_name" => "title1",
					"admin_label" => true,
					"value" => '',
					"description" => __( "Title", 'sw_woocommerce' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Product Title Length", 'sw_woocommerce' ),
					"param_name" => "title_length",
					"admin_label" => true,
					"value" => 0,
					"description" => __( "Choose Product Title Length if you want to trim word, leave 0 to not trim word", 'sw_woocommerce' )
				),		
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Description", 'sw_woocommerce' ),
					"param_name" => "description1",
					"admin_label" => true,
					"value" => '',
					"description" => __( "Description", 'sw_woocommerce' ),
				),
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Category", 'sw_woocommerce' ),
					"param_name" => "category",
					"admin_label" => true,
					"value" => $term,
					"description" => __( "Select Categories", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Select Style", 'sw_woocommerce' ),
					"param_name" => "style",
					"admin_label" => true,
					"value" => array( 'Default' => '', 'Style 1' => 'style1'),
					"description" => __( "Select Style", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "multiselect",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Select Order Product", 'sw_woocommerce' ),
					"param_name" => "select_order",
					"admin_label" => true,
					"value" => array('Latest Products' => 'latest', 'Best Sellers' => 'bestsales', 'Top Rating Products' => 'rating', 'Featured Products' => 'featured'),
					"description" => __( "Select Order Product", 'sw_woocommerce' )
				 ),			 
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Post", 'sw_woocommerce' ),
					"param_name" => "numberposts",
					"admin_label" => true,
					"value" => 5,
					"description" => __( "Number Of Post", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number row per column", 'sw_woocommerce' ),
					"param_name" => "item_row",
					"admin_label" => true,
					"value" =>array(1,2,3),
					"description" => __( "Number row per column", 'sw_woocommerce' )
				 ),	
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Tab Active", 'sw_woocommerce' ),
					"param_name" => "tab_active",
					"admin_label" => true,
					"value" => 1,
					"description" => __( "Select tab active", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns >1200px: ", 'sw_woocommerce' ),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
					"param_name" => "columns1",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
					"param_name" => "columns2",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
					"param_name" => "columns3",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
					"param_name" => "columns4",
					"admin_label" => true,
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", 'sw_woocommerce' ),
					"param_name" => "speed",
					"admin_label" => true,
					"value" => 1000,
					"description" => __( "Speed Of Slide", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", 'sw_woocommerce' ),
					"param_name" => "autoplay",
					"admin_label" => true,
					"value" => array( 'False' => 'false', 'True' => 'true' ),
					"description" => __( "Auto Play", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", 'sw_woocommerce' ),
					"param_name" => "interval",
					"admin_label" => true,
					"value" => 5000,
					"description" => __( "Interval", 'sw_woocommerce' )
				 ),			  
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
					"param_name" => "scroll",
					"admin_label" => true,
					"value" => 1,
					"description" => __( "Total Items Slided", 'sw_woocommerce' )
				 ),			 
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", 'sw_woocommerce' ),
					"param_name" => "layout",
					"admin_label" => true,
					"value" => array( 'Layout Default' => 'default', 'Layout 1' => 'layout1', 'Layout 2' => 'layout3', 'Layout 3' => 'layout4', 'Layout 4' => 'layout5', 'Layout Mobile'=>'layout2' ),
					"description" => __( "Layout", 'sw_woocommerce' )
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function SC_WooTab( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'title_length' => 0,
					'category' => '',
					'style' =>'',
					'description1'=>'',
					'select_order' => 'latest',				
					'numberposts' => 5,
					'item_row'=> 1,
					'tab_active' => 1,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'speed' => 1000,
					'autoplay' => 'false',
					'interval' => 5000,
					'show_more'  => 'yes',
					'layout'  => 'default',
					'scroll' => 1
				), $atts )
			);
			ob_start();	
			if( $layout == 'default' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'default' ) );
			}elseif( $layout == 'layout1' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'theme1' ) );
			}elseif( $layout == 'layout2' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'theme-mobile' ) );
			}elseif( $layout == 'layout3' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'theme2' ) );
			}elseif( $layout == 'layout4' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'theme3' ) );
			}elseif( $layout == 'layout5' ){
				include( sw_override_check( 'sw-woo-tab-slider', 'theme4' ) );
			}
			
			$content = ob_get_clean();
			
			return $content;
		}
		
		function sw_tab_category_callback(){
			$category 	 = ( isset( $_POST["catid"] )   	&& $_POST["catid"] != '' ) ? $_POST["catid"] : '';		
			$so          = ( isset( $_POST["sorder"] )  	&& $_POST["sorder"] != '' ) ? $_POST["sorder"] : 'latest';
			$layout      = ( isset( $_POST["layout"] )  	&& $_POST["layout"] != '' ) ? $_POST["layout"] : 'default';
			$target      = ( isset( $_POST["target"] )  	&& $_POST["target"] != '' ) ? str_replace( '#', '', $_POST["target"] ) : '';
			$numberposts = ( isset( $_POST["number"] )  	&& $_POST["number"] > 0 ) ? $_POST["number"] : 0;
			$item_row    = ( isset( $_POST["item_row"] )  && $_POST["item_row"] > 0 ) ? $_POST["item_row"] : 1;
			$columns		 = ( isset( $_POST["columns"] )   && $_POST["columns"] > 0 ) ? $_POST["columns"] : 1;
			$columns1		 = ( isset( $_POST["columns1"] )  && $_POST["columns1"] > 0 ) ? $_POST["columns1"] : 1;
			$columns2		 = ( isset( $_POST["columns2"] )  && $_POST["columns2"] > 0 ) ? $_POST["columns2"] : 1;
			$columns3		 = ( isset( $_POST["columns3"] )  && $_POST["columns3"] > 0 ) ? $_POST["columns3"] : 1;
			$columns4		 = ( isset( $_POST["columns4"] )  && $_POST["columns4"] > 0 ) ? $_POST["columns4"] : 1;
			$interval		 = ( isset( $_POST["interval"] )  && $_POST["interval"] > 0 ) ? $_POST["interval"] : 1000;
			$speed			 = ( isset( $_POST["speed"] )  	  && $_POST["speed"] > 0 ) ? $_POST["speed"] : 1000;
			$scroll			 = ( isset( $_POST["scroll"] )  	&& $_POST["scroll"] > 0 ) ? $_POST["scroll"] : 1;
			$autoplay		 = ( isset( $_POST["autoplay"] )  && $_POST["autoplay"] != '' ) ? $_POST["autoplay"] : 'false';
			$title_length = ( isset( $_POST["title_length"] )  	&& $_POST["title_length"] > 0 ) ? $_POST["title_length"] : 0;
			$Wc_Query = new WC_Query();
			$default = array();			
			if( $so == 'latest' ){
				$default = array(
					'post_type'	=> 'product',
					'paged'		=> 1,
					'showposts'	=> $numberposts,
					'orderby'	=> 'date'
				);						
			}
			if( $so == 'rating' ){
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
			if( $so == 'bestsales' ){
				$default = array(
					'post_type' 			=> 'product',							
					'post_status' 			=> 'publish',
					'ignore_sticky_posts'   => 1,
					'showposts'				=> $numberposts,
					'meta_key' 		 		=> 'total_sales',
					'orderby' 		 		=> 'meta_value_num',					
				);
			}
			if( $so == 'featured' ){
				$default = array(
					'post_type'	=> 'product',
					'post_status' 			=> 'publish',
					'ignore_sticky_posts'	=> 1,
					'showposts' 		=> $numberposts					
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
			if( $so == 'rating' && ! sw_woocommerce_version_check( '3.0' ) ){			
				remove_filter( 'posts_clauses',  array( $Wc_Query, 'order_by_rating_post_clauses' ) );
			}
	?>
		<div class="tab-pane active" id="<?php echo esc_attr( $target ) ?>">
	<?php 
			if( $list->have_posts() ) :
		?>
			<?php if( $layout == 'layout2' || $layout == 'theme-mobile') :?>
			<div id="<?php echo esc_attr( 'tab_mobile'. $target ); ?>" class=""> 
				<div class="resp-slider-container">
					<div class="items-wrapper clearfix">	
						<?php 
							$count_items = 0;
							$count_items = ( $numberposts >= $list->found_posts ) ? $list->found_posts : $numberposts;
							$i = 0;
							while($list->have_posts()): $list->the_post();					
							global $product, $post;
							$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
							$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
							if( $i % $item_row == 0 ){
						?>
							<div class="item product <?php echo esc_attr( $class )?>">
							<?php } ?>
								<div class="item-wrap">
									<div class="item-detail">
										<div class="item-image">									
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
											<?php sw_label_sales() ?>
										</div>
										<div class="item-content">
											<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
											<!-- Price -->
											<?php if ( $price_html = $product->get_price_html() ){?>
											<div class="item-price">
												<span>
													<?php echo $price_html; ?>
												</span>
											</div>
											<?php } ?>								
										</div>															
									</div>
								</div>
							<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
						<?php $i ++; endwhile; wp_reset_postdata();?>
					</div> 
				</div>
			</div>
			<?php elseif( $layout == 'layout3' || $layout == 'theme2') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
					<div class="resp-slider-container">
						<div class="slider responsive">
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
							<div class="item-wrap2">
								<div class="item-detail">										
									<div class="item-img products-thumb">		
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
									</div>										
									<div class="item-content">																			
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>				
										<?php if ( $price_html = $product->get_price_html() ){?>
										<?php 
											$rating_count = $product->get_rating_count();
											$review_count = $product->get_review_count();
											$average      = $product->get_average_rating();
										?>
										<div class="reviews-content">
											<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
										</div>	
										<div class="item-price">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>
										<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
									</div>								
								</div>
						</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
			<?php elseif( $layout == 'layout5' || $layout == 'theme5') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
				<div class="resp-slider-container">
					<div class="slider responsive">
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
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
									<div class="top-item">
									<?php echo autusin_quickview() ;?>
									<?php
									if ( class_exists( 'YITH_WCWL' ) ){
										echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
									} ?>
									<?php if ( class_exists( 'YITH_WOOCOMPARE' ) ){ 
										?>
										<a href="javascript:void(0)" class="compare button"  title="<?php esc_html_e( 'Add to Compare', 'sw_woocommerce' ) ?>" data-product_id="<?php echo esc_attr($post->ID); ?>" rel="nofollow"> <?php esc_html('compare','sw-woocomerce'); ?></a>
										<?php } ?>
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
									<?php } ?> <!-- end rating  -->
									<div class="box-cart">
										<!-- price -->
										<?php if ( $price_html = $product->get_price_html() ){?>
										<div class="item-price pull-left">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>
										<div class="item-bottom pull-right">
											<?php woocommerce_template_loop_add_to_cart(); ?>
										</div>
									</div>
								</div>								
							</div>
						</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
			<?php elseif( $layout == 'layout4' || $layout == 'theme3') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
				<div class="resp-slider-container">
					<div class="slider responsive">
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
						<div class="item-wrap2">
							<div class="item-detail">										
								<div class="item-img products-thumb">		
								<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
								</div>										
								<div class="item-content">																			
									<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
									<?php if ( $price_html = $product->get_price_html() ){?>
									<?php 
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
									?>
									<div class="reviews-content">
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
									</div>	
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
									<?php } ?>
									<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
								</div>								
							</div>
						</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
			<?php elseif( $layout == 'layout6' || $layout == 'theme6') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
				<div class="resp-slider-container">
					<div class="slider responsive">
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
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
											
										</div>										
										<div class="item-content">	
																														
											<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
												<!-- price -->
												<?php if ( $price_html = $product->get_price_html() ){?>
												<div class="item-price pull-left">
													<span>
														<?php echo $price_html; ?>
													</span>
												</div>
												<?php } ?>
										</div>								
									</div>
								</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
		<?php elseif( $layout == 'layout7' || $layout == 'theme7') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
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

		<?php elseif( $layout == 'layout5' || $layout == 'theme4') :?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
						<div class="resp-slider-container">
								<div class="slider responsive">
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
								<div class="item-wrap2">
									<div class="item-detail">										
										<div class="item-img products-thumb">		
										<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
										</div>										
										<div class="item-content">																			
											<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>
											<?php if ( $price_html = $product->get_price_html() ){?>
											<?php 
												$rating_count = $product->get_rating_count();
												$review_count = $product->get_review_count();
												$average      = $product->get_average_rating();
											?>
											<div class="reviews-content">
												<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
											</div>	
											<div class="item-price">
												<span>
													<?php echo $price_html; ?>
												</span>
											</div>
											<?php } ?>
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>								
									</div>
								</div>
								<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
							<?php $i++; $j++; endwhile; wp_reset_postdata();?>
							</div>
						</div>
					</div>
			<?php else: ?>
			<div id="<?php echo esc_attr( 'tab_'. $target ); ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
				<div class="resp-slider-container">
						<div class="slider responsive">
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
							<div class="item-wrap">
								<div class="item-detail">										
									<div class="item-img products-thumb">		
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
									</div>										
									<div class="item-content">																			
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php sw_trim_words( get_the_title(), $title_length ); ?></a></h4>								
										<!-- price -->
										<?php if ( $price_html = $product->get_price_html() ){?>
											<div class="item-price">
												<span>
													<?php echo $price_html; ?>
												</span>
											</div>
										<?php } ?>
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
									</div>								
								</div>
						</div>
						<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
					<?php $i++; $j++; endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php 
			else :
				echo '<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p>'. esc_html__( 'There is not product on this tab', 'sw_woocommerce' ) .'</p>
				</div>';
			endif;
			echo '</div>';
			exit;
		}
		
		/**
		 * Display the widget on the screen.
		 */
		public function widget( $args, $instance ) {
			extract($args);
			
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

			if ( !array_key_exists('layout', $instance) ){
				$instance['layout'] = 'default';
			}
			extract($instance);
		
			if ( $tpl = sw_override_check( 'sw-woo-tab-slider', $instance['layout'] ) ){ 
				$link_img = plugins_url('images/', __FILE__);
				//$widget_id = $args['widget_id'];		
				include $tpl;
			}
					
			/* After widget (defined by themes). */
			echo $after_widget;
		}    
		
		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// strip tag on text field
			$instance['title1'] = strip_tags( $new_instance['title1'] );
			$instance['title_length'] = intval( $new_instance['title_length'] );
			$instance['description'] = strip_tags( $new_instance['description'] );
			// int or arra
			$instance['category'] = $new_instance['category'];
			if ( array_key_exists('select_order', $new_instance) ){
				if ( is_array($new_instance['select_order']) ){
					$instance['select_order'] = $new_instance['select_order'];
				} else {
					$instance['select_order'] = strip_tags( $new_instance['select_order'] );
				}
			}		
			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
			}
			if ( array_key_exists('number_child', $new_instance) ){
				$instance['number_child'] = intval( $new_instance['number_child'] );
			}
			
			if ( array_key_exists('banner_links', $new_instance) ){
				$instance['banner_links'] = esc_url( $new_instance['banner_links'] );
			}
			if ( array_key_exists('img_banners', $new_instance) ){
				$instance['img_banners'] = strip_tags( $new_instance['img_banners'] );
			}
			if ( array_key_exists('item_row', $new_instance) ){
				$instance['item_row'] = intval( $new_instance['item_row'] );
			}
			if ( array_key_exists('tab_active', $new_instance) ){
				$instance['tab_active'] = intval( $new_instance['tab_active'] );
			}
			if ( array_key_exists('style', $new_instance) ){
				$instance['style'] = $new_instance['style'];
			}		
			if ( array_key_exists('columns', $new_instance) ){
				$instance['columns'] = intval( $new_instance['columns'] );
			}
			if ( array_key_exists('columns1', $new_instance) ){
				$instance['columns1'] = intval( $new_instance['columns1'] );
			}
			if ( array_key_exists('columns2', $new_instance) ){
				$instance['columns2'] = intval( $new_instance['columns2'] );
			}
			if ( array_key_exists('columns3', $new_instance) ){
				$instance['columns3'] = intval( $new_instance['columns3'] );
			}
			if ( array_key_exists('columns4', $new_instance) ){
				$instance['columns4'] = intval( $new_instance['columns4'] );
			}
			if ( array_key_exists('interval', $new_instance) ){
				$instance['interval'] = intval( $new_instance['interval'] );
			}
			if ( array_key_exists('speed', $new_instance) ){
				$instance['speed'] = intval( $new_instance['speed'] );
			}
			if ( array_key_exists('start', $new_instance) ){
				$instance['start'] = intval( $new_instance['start'] );
			}
			if ( array_key_exists('scroll', $new_instance) ){
				$instance['scroll'] = intval( $new_instance['scroll'] );
			}	
			if ( array_key_exists('autoplay', $new_instance) ){
				$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
			}
			if ( array_key_exists('show_more', $new_instance) ){
				$instance['show_more'] = strip_tags( $new_instance['show_more'] );
			}
			$instance['layout'] = strip_tags( $new_instance['layout'] );
			
						
			
			return $instance;
		}

		function category_select( $field_name, $opts = array(), $field_value = null ){
			$default_options = array(
					'multiple' => false,
					'disabled' => false,
					'size' => 5,
					'class' => 'widefat',
					'required' => false,
					'autofocus' => false,
					'form' => false,
			);
			$opts = wp_parse_args($opts, $default_options);
		
			if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
				$opts['multiple'] = 'multiple';
				if ( !is_numeric($opts['size']) ){
					if ( intval($opts['size']) ){
						$opts['size'] = intval($opts['size']);
					} else {
						$opts['size'] = 5;
					}
				}
			} else {
				// is not multiple
				unset($opts['multiple']);
				unset($opts['size']);
				if (is_array($field_value)){
					$field_value = array_shift($field_value);
				}
				if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
					unset($opts['allow_select_all']);
					$allow_select_all = '<option value="">All Categories</option>';
				}
			}
		
			if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
				$opts['disabled'] = 'disabled';
			} else {
				unset($opts['disabled']);
			}
		
			if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
				$opts['required'] = 'required';
			} else {
				unset($opts['required']);
			}
		
			if ( !is_string($opts['form']) ) unset($opts['form']);
		
			if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
		
			$opts['id'] = $this->get_field_id($field_name);
		
			$opts['name'] = $this->get_field_name($field_name);
			if ( isset($opts['multiple']) ){
				$opts['name'] .= '[]';
			}
			$select_attributes = '';
			foreach ( $opts as $an => $av){
				$select_attributes .= "{$an}=\"{$av}\" ";
			}
			
			$categories = get_terms('product_cat');
			// print '<pre>'; var_dump($categories);
			// if (!$layout) return '';
			$all_category_ids = array();
			foreach ($categories as $cat) $all_category_ids[] = $cat->slug;
			
			$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
			if (!$is_valid_field_value && is_array($field_value)){
				$intersect_values = array_intersect($field_value, $all_category_ids);
				$is_valid_field_value = count($intersect_values) > 0;
			}
			if (!$is_valid_field_value){
				$field_value = '0';
			}
		
			$select_html = '<select ' . $select_attributes . '>';
			if (isset($allow_select_all)) $select_html .= $allow_select_all;
			foreach ($categories as $cat){
				$select_html .= '<option value="' . $cat->slug . '"';
				if ($cat->slug == $field_value || (is_array($field_value)&&in_array($cat->slug, $field_value))){ $select_html .= ' selected="selected"';}
				$select_html .=  '>'.$cat->name.'</option>';
			}
			$select_html .= '</select>';
			return $select_html;
		}
		

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		public function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults 			= array();
			$instance 			= wp_parse_args( (array) $instance, $defaults ); 		
			$title1					= isset( $instance['title1'] )      	? strip_tags($instance['title1']) : '';
			$description					= isset( $instance['description'] )      	? strip_tags($instance['description']) : '';
			$number_child     		= isset( $instance['number_child'] ) 	? intval($instance['number_child']) : 5;
			$title_length		= isset( $instance['title_length'] ) ? intval($instance['title_length']) : '';  
			$categoryid 		= isset( $instance['category'] )    	? $instance['category'] : '';
			$select_order   = isset( $instance['select_order'] ) ? $instance['select_order'] : array();		
			$number     		= isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$banner_links	= isset( $instance['banner_links'] )     	? esc_url($instance['banner_links']) : '';				
			$img_banners	= isset( $instance['img_banners'] )     	? strip_tags($instance['img_banners']) : '';	
			$item_row     	= isset( $instance['item_row'] )      ? intval($instance['item_row']) : 1;
			$length     		= isset( $instance['length'] )      	? intval($instance['length']) : 25;
			$tab_active    	= isset( $instance['tab_active'] )    ? intval($instance['tab_active']) : 1;
			$columns     		= isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     	= isset( $instance['columns1'] )      ? intval($instance['columns1']) : 1;
			$columns2     	= isset( $instance['columns2'] )      ? intval($instance['columns2']) : 1;
			$columns3     	= isset( $instance['columns3'] )      ? intval($instance['columns3']) : 1;
			$columns4    		= isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     	= isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'false';
			$interval     	= isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
			$speed     			= isset( $instance['speed'] )      		? intval($instance['speed']) : 1000;
			$scroll     		= isset( $instance['scroll'] )      	? intval($instance['scroll']) : 1;
			$show_more   		= isset( $instance['show_more'] ) 		? strip_tags($instance['show_more']) : 'yes';
			$layout = isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
					   
					 
			?>

			</p> 
			  <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
					type="text"	value="<?php echo esc_attr($title1); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title_length'); ?>"><?php _e('Product Title Length', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>"
					type="text"	value="<?php echo esc_attr($title_length); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"
					type="text"	value="<?php echo esc_attr($description); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('img_banners'); ?>"><?php _e('Image attachment ID', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('img_banners'); ?>" name="<?php echo $this->get_field_name('img_banners'); ?>"
					type="attach_images"	value="<?php echo esc_attr($img_banners); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('banner_links'); ?>"><?php _e('Banner Links', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('banner_links'); ?>" name="<?php echo $this->get_field_name('banner_links'); ?>"
					type="text"	value="<?php echo esc_attr($banner_links); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'sw_woocommerce')?></label>
				<br />
				<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('select_order'); ?>"><?php _e('Select Order', 'sw_woocommerce')?></label>
				<br />
				<?php $allowed_key = array('latest' => 'Latest Products', 'bestsales' => 'Best Sellers', 'rating' => 'Top Rating Products', 'featured' => 'Featured Products'); ?>
				<select class="widefat"
					id="<?php echo $this->get_field_id('select_order'); ?>"
					name="<?php echo $this->get_field_name('select_order').'[]'; ?>" multiple>
					<?php
					$option ='';
					foreach ($allowed_key as $value => $key) :
						$option .= '<option value="' . $value . '" ';
						if ( in_array( $value, $select_order ) ){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p>
				
			<p>
				<label for="<?php echo $this->get_field_id('number_child'); ?>"><?php _e('Number child of posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('number_child'); ?>" name="<?php echo $this->get_field_name('number_child'); ?>"
					type="text"	value="<?php echo esc_attr($number_child); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>

			<?php $row_number = array( '1' => 1, '2' => 2, '3' => 3 ); ?>
			<p>
				<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column:  ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('item_row'); ?>"
					name="<?php echo $this->get_field_name('item_row'); ?>">
					<?php
					$option ='';
					foreach ($row_number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $item_row){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<?php $styles_args = array('' => 'Select', 'style1' => 'style1'); ?>
			<p>
				<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('style'); ?>"
					name="<?php echo $this->get_field_name('style'); ?>">
					<?php
					$option ='';
					foreach ($styles_args as $value => $key) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $style){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('tab_active'); ?>"><?php _e('Tab active: ', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat"
					id="<?php echo $this->get_field_id('tab_active'); ?>" name="<?php echo $this->get_field_name('tab_active'); ?>" type="text" 
					value="<?php echo esc_attr($tab_active); ?>" />
			</p> 
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
			<p>
				<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns'); ?>"
					name="<?php echo $this->get_field_name('columns'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns1'); ?>"
					name="<?php echo $this->get_field_name('columns1'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns1){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns2'); ?>"
					name="<?php echo $this->get_field_name('columns2'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns2){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns3'); ?>"
					name="<?php echo $this->get_field_name('columns3'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns3){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('columns4'); ?>"
					name="<?php echo $this->get_field_name('columns4'); ?>">
					<?php
					$option ='';
					foreach ($number as $key => $value) :
						$option .= '<option value="' . $value . '" ';
						if ($value == $columns4){
							$option .= 'selected="selected"';
						}
						$option .=  '>'.$key.'</option>';
					endforeach;
					echo $option;
					?>
				</select>
			</p> 
			
			<p>
				<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
					<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
					<?php } ?>>
						<?php _e('False', 'sw_woocommerce')?>
					</option>
					<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
						<?php _e('True', 'sw_woocommerce')?>
					</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
					type="text"	value="<?php echo esc_attr($interval); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
					type="text"	value="<?php echo esc_attr($speed); ?>" />
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
					type="text"	value="<?php echo esc_attr($scroll); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('show_more'); ?>"><?php _e("Show More Category", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('show_more'); ?>"	name="<?php echo $this->get_field_name('show_more'); ?>">
					<option value="yes" <?php if ($show_more=='yes'){?> selected="selected"
					<?php } ?>>
						<?php _e('Yes', 'sw_woocommerce')?>
					</option>
					<option value="no" <?php if ($show_more=='no'){?> selected="selected"
					<?php } ?>>
						<?php _e('No', 'sw_woocommerce')?>
					</option>				
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e("Template", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
					<option value="default" <?php if ($layout=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_woocommerce')?>
					</option>

					<option value="theme1" <?php if ($layout=='theme1'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 1', 'sw_woocommerce')?>
					</option>
					<option value="theme2" <?php if ($layout=='theme2'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 2', 'sw_woocommerce')?>
					</option>	
					<option value="theme3" <?php if ($layout=='theme3'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 3', 'sw_woocommerce')?>
					</option>
					<option value="theme4" <?php if ($layout=='theme4'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 4', 'sw_woocommerce')?>
					</option>
					<option value="theme5" <?php if ($layout=='theme5'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 5', 'sw_woocommerce')?>
					</option>
					<option value="theme6" <?php if ($layout=='theme6'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 6', 'sw_woocommerce')?>
					</option>
					<option value="theme7" <?php if ($layout=='theme7'){?> selected="selected"
					<?php } ?>>
						<?php _e('Layout 7', 'sw_woocommerce')?>
					</option>
				</select>
			</p>               
		<?php
		}		
	}
}
?>
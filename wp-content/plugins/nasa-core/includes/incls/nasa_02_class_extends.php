<?php
/**
 * Extended WC_Product_Cat_List_Walker
 */
if (class_exists('WC_Widget')) {
    if (!class_exists('WC_Product_Cat_List_Walker') ) {
        require_once WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php';
    }
    
    class Nasa_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {
        protected $_icons = array();
        protected $_k = 0;
        protected $_show_default = 0;

        public function setIcons($instance) {
            $this->_icons = $instance;
        }

        public function setShowDefault($show) {
            $this->_show_default = (int) $show;
        }

        public function getTotalRoot() {
            return $this->_k;
        }

        /**
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of category in reference to parents.
         * @param integer $current_object_id
         */
        public function start_el(&$output, $cat, $depth = 0, $args = array(), $current_object_id = 0) {
            $output .= '<li class="cat-item cat-item-' . $cat->term_id . ' cat-item-' . $cat->slug;
            $nasa_active = $accodion = $icon = '';
            if ($depth == 0) {
                $output .= ' root-item';
                if ($this->_show_default && ($this->_k >= $this->_show_default)) {
                    $output .= ' nasa-show-less';
                }
                $this->_k++;
            }
            if (isset($this->_icons['cat_' . $cat->slug]) && trim($this->_icons['cat_' . $cat->slug]) != '') {
                $icon = '<i class="' . $this->_icons['cat_' . $cat->slug] . '"></i>';
                $icon .= '&nbsp;&nbsp;';
            }

            if ($args['current_category'] == $cat->term_id) {
                $output .= ' current-cat active';
                $nasa_active = ' nasa-active';
            }

            if ($args['has_children'] && $args['hierarchical']) {
                $output .= ' cat-parent li_accordion';
                $accodion = $args['current_category'] == $cat->term_id ? 
                    '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-less"></span></a>':
                    '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-plus"></span></a>';
            }

            if ($args['current_category_ancestors'] && $args['current_category'] && in_array($cat->term_id, $args['current_category_ancestors'])) {
                $output .= ' current-cat-parent active';
                $accodion = '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-less"></span></a>';
            }

            $output .= '">' . $accodion;

            $output .= '<a href="' . get_term_link($cat, $this->tree_type) . '" data-id="' . esc_attr((int) $cat->term_id) . '" class="nasa-filter-by-cat' . $nasa_active . '">' . $icon . $cat->name;
            $output .= $args['show_count'] ? ' <span class="count">(' . $cat->count . ')</span>' : '';
            $output .= '</a>';
        }
    }
    
    class Nasa_Product_Brand_List_Walker extends WC_Product_Cat_List_Walker {
        
        protected $_icons = array();
        protected $_k = 0;
        protected $_show_default = 0;
        protected $_filter_type = 'only';
        protected $_class_ajax = 'nasa-filter-by-cat';

        public function __construct() {
            $this->tree_type = Nasa_Product_Brands_Widget::TAX_NAME;
        }

        public function setIcons($instance) {
            $this->_icons = $instance;
        }

        public function setFilterType($type = 'only') {
            $this->_filter_type = $type == 'or' ? 'or' : 'only';
            $this->_class_ajax = $this->_filter_type == 'only' ? 'nasa-filter-by-cat' : 'nasa-filter-by-brand';
        }
        
        public function setShowDefault($show) {
            $this->_show_default = (int) $show;
        }

        public function getTotalRoot() {
            return $this->_k;
        }

        /**
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of category in reference to parents.
         * @param integer $current_object_id
         */
        public function start_el(&$output, $brand, $depth = 0, $args = array(), $current_object_id = 0) {
            $output .= '<li class="cat-item cat-item-' . $brand->term_id . ' cat-item-' . $brand->slug;
            $nasa_active = $accodion = $icon = '';
            if ($depth == 0) {
                $output .= ' root-item';
                if ($this->_show_default && ($this->_k >= $this->_show_default)) {
                    $output .= ' nasa-show-less';
                }
                $this->_k++;
            }
            if (isset($this->_icons['brand_' . $brand->slug]) && trim($this->_icons['brand_' . $brand->slug]) != '') {
                $icon = '<i class="nasa-brand-icon ' . $this->_icons['brand_' . $brand->slug] . '"></i>';
            }

            if ($args['current_brand'] == $brand->term_id) {
                $output .= ' current-cat active';
                $nasa_active = ' nasa-active';
            }

            if ($args['has_children'] && $args['hierarchical']) {
                $output .= ' cat-parent li_accordion';
                $accodion = $args['current_brand'] == $brand->term_id ? 
                    '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-less"></span></a>':
                    '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-plus"></span></a>';
            }

            if ($args['current_brand_ancestors'] && $args['current_brand'] && in_array($brand->term_id, $args['current_brand_ancestors'])) {
                $output .= ' current-cat-parent active';
                $accodion = '<a href="javascript:void(0);" class="accordion" data-class_show="pe-7s-plus" data-class_hide="pe-7s-less"><span class="icon pe-7s-less"></span></a>';
            }
            
            $output .= '">' . $accodion;

            $href = get_term_link($brand, $this->tree_type);
            $output .= '<a href="' . esc_url($href) . '" ' .
                'data-id="' . esc_attr((int) $brand->term_id) . '" ' .
                'data-slug="' . esc_attr($brand->slug) . '" ' .
                'class="' . $this->_class_ajax . $nasa_active . '" ' .
                'data-taxonomy="' . $this->tree_type . '">' . 
                    $icon . $brand->name;
            $output .= $args['show_count'] ? ' <span class="count">(' . $brand->count . ')</span>' : '';
            $output .= '</a>';
        }

    }
}
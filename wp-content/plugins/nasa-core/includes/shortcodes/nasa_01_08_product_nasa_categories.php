<?php
function nasa_sc_product_nasa_categories($atts = array(), $content = null) {
    global $woocommerce, $nasa_opt;
    
    if ((isset($nasa_opt['enable_nasa_custom_categories']) && !$nasa_opt['enable_nasa_custom_categories']) || !$woocommerce) {
        return $content;
    }
    
    $dfAttr = array(
        'style' => 'hoz',
        'hide_empty' => '0',
        'count_items' => '0',
        'deep_level' => '3',
        'button_text' => '',
        'el_class' => '',
    );
    extract(shortcode_atts($dfAttr, $atts));
    
    $nasa_taxonomy = apply_filters('nasa_taxonomy_custom_cateogory', Nasa_WC_Taxonomy::$nasa_taxonomy);
    
    $max_deep = apply_filters('nasa_max_deep_product_group', 3);
    $max_level = $deep_level > $max_deep || $deep_level < 1 ? $max_deep : $deep_level;
    
    $class_form = 'cart';
    $class_form .= ' nasa-style-' . $style;
    $class_form .= $el_class ? ' ' . $el_class : '';
    
    $class_wrap_all = 'large-10 columns rtl-right';
    $class_wrap_btn = 'large-2 columns rtl-left nasa-wrap-button desktop-padding-left-5 rtl-desktop-padding-left-10 rtl-desktop-padding-right-5';
    if ($style !== 'ver') {
        switch ($max_level) :
            case 1:
                $class_wrap = 'large-12 columns rtl-right';
                break;
            case 2:
                $class_wrap = 'large-6 columns rtl-right';
                break;
            case 3:
                $class_wrap = 'large-4 columns rtl-right';
                break;
            default:
                $class_wrap = apply_filters('nasa_product_group_column_class', 'large-3 columns rtl-right');
                break;
        endswitch;
    } else {
        $class_wrap = 'large-12 columns margin-bottom-20';
        $class_wrap_all = 'large-12 columns';
        $class_wrap_btn = 'large-12 columns nasa-wrap-button margin-top-30';
    }
    
    $hideEmpty = isset($hide_empty) && $hide_empty ? '1' : '0';
    $arrayCats = array();
    $arrayCatsAct = array();
    $currentTerm = null;
    $k = 0;
    
    $active_slug = isset($_REQUEST[$nasa_taxonomy]) ? $_REQUEST[$nasa_taxonomy] : null;
    if ($active_slug) {
        $currentTerm = get_term_by('slug', $active_slug, $nasa_taxonomy);
        if (isset($currentTerm->term_id)) {
            $childTerms = get_terms( 
                array(
                    'taxonomy' => $nasa_taxonomy,
                    'parent' => $currentTerm->term_id,
                    'hide_empty' => $hideEmpty,
                    'menu_order' => 'asc'
                )
            );
            
            if ($childTerms) {
                $arrayCats[$k] = $childTerms;
                $arrayCatsAct[$k] = $active_slug;
                $k++;
            }
        }
    }
    
    nasa_recursive_nasa_cats($arrayCats, $arrayCatsAct, $k, $currentTerm, $nasa_taxonomy, $hideEmpty);
    $action_form = '';
    if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
        $action_form = ' action="' . esc_url(wc_get_page_permalink('shop')) . '"';
    }
    
    $emptySelect = nasa_render_select_nasa_cats_empty();
    $content = '<form class="' . $class_form . '" method="get" data-hide_empty="' . $hideEmpty . '" data-show_count="' . $count_items . '"' . $action_form . '>' .
        '<div class="row"><div class="' . $class_wrap_all . ' nasa-selector"><div class="row">';
    
    $level = 0;
    if ($arrayCats) {
        for ($n = $k; $n >= 0; $n--) {
            $emptySelect = nasa_render_select_nasa_cats_empty($level + 1);
            $currents = $arrayCats[$n];

            $content .= '<div class="' . $class_wrap . ' nasa-wrap-select" data-active="' . (isset($arrayCatsAct[$n]) ? $arrayCatsAct[$n] : '') . '">';
            $content .= '<select data-key="' . $level . '" data-target=".nasa-select-' . ($level + 1) . '" class="nasa-select2 nasa-filter-nasa-categories nasa-select-' . $level . '" data-text_select="' . $emptySelect . '">';
            $content .= '<option value="">' . $emptySelect . '</option>';

            foreach ($currents as $item) {
                $active = '';
                if (isset($arrayCatsAct[$n]) && $arrayCatsAct[$n] == $item->slug) {
                    $active = ' selected';
                }
                
                $label = $count_items ? $item->name . ' (' . $item->count . ')' : $item->name;
                $content .= '<option value="' . $item->slug . '"' . $active . '>' . $label . '</option>';
            }

            $content .= '</select></div>';

            $level++;
            if ($level >= $max_level) {
                break;
            }
        }
    }
    
    if ($level < $max_level) {
        for ($n = $level; $n < $max_level; $n++) {
            $emptySelect = nasa_render_select_nasa_cats_empty($n + 1);
            $content .= '<div class="' . $class_wrap . ' nasa-wrap-select">' .
                '<select data-key="' . $n . '" data-target=".nasa-select-' . ($n + 1) . '" class="nasa-select2 nasa-filter-nasa-categories nasa-select-' . $n . '" data-text_select="' . $emptySelect . '">';
            $content .= '<option value="">' . $emptySelect . '</option>';
            $content .= '</select></div>';
        }
    }
    
    $content .= '</div></div>';
    
    /**
     * Button filter
     */
    
    $btn_text = trim($button_text) !== '' ? $button_text : esc_html__('Select', 'nasa-core');
    $content .= '<div class="' . $class_wrap_btn . '">';
    $content .= '<a class="button nasa-submit-form" href="javascript:void(0);">' . $btn_text . '</a>';
    $content .= '</div>';
    
    /**
     * Input name
     */
    $content .= '<input class="nasa-input-main nasa-custom-cat" type="hidden" name="' . $nasa_taxonomy . '" value="' . $active_slug . '" />';
    
    /**
     * GETS
     */
    if (!empty($_GET)) {
        foreach ($_GET as $name => $value) {
            if ($nasa_taxonomy !== $name) {
                $content .= '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
            }
        }
    }
    
    $content .= '</div></form>';
    
    return $content;
}

/**
 * Recursive Nasa Categories
 */
function nasa_recursive_nasa_cats(
    &$arrayCats = array(),
    &$arrayCatsAct = array(),
    &$k = 0,
    $currentTerm = null,
    $nasa_taxonomy = '',
    $hideEmpty = '0'
) {
    if (isset($currentTerm->parent) && $currentTerm->parent) {
        $parentCat = get_term_by('term_id', $currentTerm->parent, $nasa_taxonomy);
        $currentCats = get_terms( 
            array(
                'taxonomy' => $nasa_taxonomy,
                'parent' => $currentTerm->parent,
                'hide_empty' => $hideEmpty,
                'menu_order' => 'asc'
            )
        );

        if ($currentCats) {
            $arrayCats[$k] = $currentCats;
            $arrayCatsAct[$k] = $currentTerm->slug;
            $k++;
        }
        // $currentTermId = 
        nasa_recursive_nasa_cats($arrayCats, $arrayCatsAct, $k, $parentCat, $nasa_taxonomy, $hideEmpty);
    }
    
    else {
        $roots = get_terms( 
            array(
                'taxonomy' => $nasa_taxonomy,
                'parent' => 0,
                'hide_empty' => $hideEmpty,
                'menu_order' => 'asc'
            )
        );
        
        if ($roots) {
            $arrayCats[$k] = $roots;
            $arrayCatsAct[$k] = isset($currentTerm->slug) ? $currentTerm->slug : null;
        }
    }
}

// **********************************************************************// 
// ! Register New Element: nasa products by ids
// **********************************************************************//
function nasa_register_product_nasa_categories(){
    $max_deep = apply_filters('nasa_max_deep_product_group', 3);
    $array_opts = array();
    for($i = $max_deep; $i>=1; $i--) {
        $array_opts[] = $i;
    }
    vc_map(array(
        "name" => esc_html__("Nasa Categories", 'nasa-core'),
        "base" => "nasa_product_nasa_categories",
        'icon' => 'icon-wpb-nasatheme',
        'description' => esc_html__("Filter products by Nasa Categories.", 'nasa-core'),
        "class" => "",
        "category" => 'Nasa Core',
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Style", 'nasa-core'),
                "param_name" => "style",
                "value" => array(
                    esc_html__('Horizontal', 'nasa-core') => 'hoz',
                    esc_html__('Vertical', 'nasa-core') => 'ver'
                ),
                "std" => 'hoz',
                "admin_label" => true,
                "description" => esc_html__("Style Element.", 'nasa-core')
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Hide Empty", 'nasa-core'),
                "param_name" => "hide_empty",
                "value" => array(
                    esc_html__('No', 'nasa-core') => '0',
                    esc_html__('Yes', 'nasa-core') => '1'
                ),
                "std" => 'no',
                "admin_label" => true,
                "description" => esc_html__("Hide Nasa Category empty product.", 'nasa-core')
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show Count products", 'nasa-core'),
                "param_name" => "count_items",
                "value" => array(
                    esc_html__('No', 'nasa-core') => '0',
                    esc_html__('Yes', 'nasa-core') => '1'
                ),
                "std" => '0',
                "admin_label" => true,
                "description" => esc_html__("Show count products.", 'nasa-core')
            ),
            
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Deep Level", 'nasa-core'),
                "param_name" => "deep_level",
                "value" => $array_opts,
                "std" => 3,
                "admin_label" => true,
                "description" => esc_html__("Deep level Categories show.", 'nasa-core')
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Filter Text", 'nasa-core'),
                "param_name" => "button_text",
                "description" => esc_html__("Input text for button.", 'nasa-core')
            ),
            
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra class name", 'nasa-core'),
                "param_name" => "el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nasa-core')
            ),
        )
    ));
}

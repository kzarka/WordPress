<?php

/**
 * Nasa Wishlist
 */
if (!NASA_WISHLIST_ENABLE && NASA_WOO_ACTIVED) :

    class FLOZEN_WOO_WISHLIST {
        
        /**
         * instance of the class
         */
        protected static $instance = null;

        /**
         * Current Language
         */
        public $current_lang = '';
        
        /**
         * List Languages
         */
        public $languages = array();

        /**
         * Cookie name
         */
        public $cookie_name = 'nasa_wishlist';
        
        /**
         * wishlist_list
         */
        public $wishlist_list = array();
        
        /**
         * expire time
         */
        public $expire = 0;

        /**
         * Init Class
         */
        public static function init() {
            global $nasa_opt;

            if (isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) {
                return null;
            }

            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }
        
        /**
         * Constructor.
         */
        public function __construct() {
            $siteurl = get_option('siteurl');
            $this->cookie_name .= $siteurl ? '_' . md5($siteurl) : '';
            
            $this->current_lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_option('WPLANG');
            if (trim($this->current_lang) == '') {
                $this->current_lang = 'default';
            }
            
            $this->languages = array($this->current_lang);
            
            /**
             * Support WPML
             */
            if (function_exists('icl_get_languages')) {
                $wpml_langs = icl_get_languages('skip_missing=0&orderby=code');
                
                if (!empty($wpml_langs)) {
                    foreach ($wpml_langs as $lang) {
                        if (isset($lang['language_code']) && !in_array($lang['language_code'], $this->languages)) {
                            $this->languages[] = $lang['language_code'];
                        }
                    }
                }
            }
            
            $this->wishlist_list = $this->get_wishlist_list();
            
            $this->expire = NASA_TIME_NOW + (60*60*24*30); // 30 days
            
            add_action('nasa_wishlist_compare_in_single', array($this, 'btn_wishlist'));
        }
        
        /**
         * get Cookie Name
         * 
         * @return type
         */
        public function get_cookie_name($_lang = null) {
            $lang = !$_lang ? $this->current_lang : $_lang;
            return $this->cookie_name . '_' . $lang;
        }
        
        /**
         * Get Wishlist items id
         */
        public function get_wishlist_list($_lang = null) {
            $wishlists = isset($_COOKIE[$this->get_cookie_name($_lang)]) ? json_decode($_COOKIE[$this->get_cookie_name($_lang)]) : array();
            
            if (!is_array($wishlists)) {
                $wishlists = array();
            }
            
            return $wishlists;
        }
        
        /**
         * Get Wishlist items id of Current language
         */
        public function get_current_wishlist() {
            return $this->wishlist_list;
        }

        /**
         * btn wishlist in list
         * 
         * @global type $product
         */
        public function btn_wishlist() {
            global $product;
            
            $variation = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            if ($productType == 'variation') {
                $variation_product = $product;
                $productId = wp_get_post_parent_id($productId);
                $parentProduct = wc_get_product($productId);
                $productType = $parentProduct->get_type();
                
                $GLOBALS['product'] = $parentProduct;
                $variation = true;
            }
            ?>

            <a href="javascript:void(0);" class="btn-wishlist btn-link wishlist-icon tip-top btn-nasa-wishlist" data-prod="<?php echo absint($productId); ?>" data-prod_type="<?php echo esc_attr($productType); ?>" title="<?php esc_attr_e('Wishlist', 'flozen-theme'); ?>">
                <i class="nasa-icon icon-v2-nasa-wishlist"></i>
                <span class="hidden-tag nasa-icon-text nasa-text no-added">&nbsp;&nbsp;<?php esc_html_e('Wishlist', 'flozen-theme'); ?></span>
            </a>

            <?php
            if ($variation) {
                $GLOBALS['product'] = $variation_product;
            }
        }
        
        /**
         * btn wishlist in list
         * 
         * @global type $product
         */
        public function btn_in_list() {
            $this->btn_wishlist();
        }

        /**
         * Add Wishlist
         */
        public function add_to_wishlist($_product_id) {
            $product_id = intval($_product_id);
            
            if (!$product_id) {
                return false;
            }
            
            if ($this->languages) {
                foreach ($this->languages as $lang) {
                    $wishlists = $this->get_wishlist_list($lang);
                    
                    if ($this->current_lang == $lang) {
                        $wishlists[] = $product_id;
                        $this->wishlist_list = $wishlists;
                    }
                    
                    /**
                     * Support WPML
                     */
                    else {
                        if (class_exists('SitePress') && function_exists('icl_object_id')) {
                            $product_langID = icl_object_id($product_id, 'product', true, $lang);
                            $wishlists[] = $product_langID;
                        }
                    }
                    
                    $this->set_cookie_wishlist($lang, $wishlists);
                }
            }
            
            return true;
        }
        
        /**
         * Remove from Wishlist
         */
        public function remove_from_wishlist($_product_id) {
            $product_id = intval($_product_id);
            
            if (!$product_id) {
                return false;
            }
            
            if ($this->languages) {
                foreach ($this->languages as $lang) {
                    if ($this->current_lang == $lang) {
                        $wishlists = $this->wishlist_list;
                        
                        if ($wishlists) {
                            foreach ($wishlists as $k => $v) {
                                if ($v == $product_id) {
                                    unset($wishlists[$k]);
                                }
                            }
                        }
                        
                        $this->wishlist_list = $wishlists;
                    }
                    
                    /**
                     * Support WPML
                     */
                    else {
                        $wishlists = $this->get_wishlist_list($lang);
                        if (class_exists('SitePress') && function_exists('icl_object_id')) {
                            if ($wishlists) {
                                $product_langID = icl_object_id($product_id, 'product', true, $lang);
                                
                                foreach ($wishlists as $k => $v) {
                                    if ($v == $product_langID) {
                                        unset($wishlists[$k]);
                                    }
                                }
                            }
                        }
                    }
                    
                    $this->set_cookie_wishlist($lang, $wishlists);
                }
            }
            
            return true;
        }
        
        /**
         * Count wishlist items
         * 
         * @return type
         */
        public function count_items() {
            return count($this->wishlist_list);
        }

        /**
         * Set cookie wishlist
         */
        protected function set_cookie_wishlist($lang = null, $wishlists = array()) {
            setcookie($this->get_cookie_name($lang), json_encode(array_values($wishlists)), $this->expire, COOKIEPATH, COOKIE_DOMAIN, false, false);
        }
        
        /**
         * Wishlist html
         */
        public function wishlist_html() {
            global $nasa_opt;
            
            $wishlist_items = $this->wishlist_list;
            
            $file = FLOZEN_CHILD_PATH . '/includes/nasa-sidebar-wishlist_html.php';
            include is_file($file) ? $file : FLOZEN_THEME_PATH . '/includes/nasa-sidebar-wishlist_html.php';
        }
    }

    /**
     * Init NasaTheme Wishlist
     */
    add_action('init', 'flozen_woo_wishlist');
    if (!function_exists('flozen_woo_wishlist')) :
        function flozen_woo_wishlist() {
            return FLOZEN_WOO_WISHLIST::init();
        }
    endif;
endif;

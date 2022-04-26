<?php

namespace App\Services;

/**
 * ProductService
 */
class ProductService
{
	public const TAXONOMY = 'product_cat';
	function __construct()
	{
		
	}

	public function init()
	{

	}

	public function getRandomTax()
	{
		// Get all terms
		$terms = get_terms( array(
		    'taxonomy'      => self::TAXONOMY,
		    'hide_empty'    => false,
		) );

		// Randomize Term Array
		shuffle( $terms );

		// Grab Indices 0 - 3, 4 in total
		$random_terms = array_slice( $terms, 0, 4 );
		if (empty($random_terms)) return [];
		$ids = [];
		foreach ($random_terms as $key => $value) {
			$value = get_object_vars($value);
			$ids[] = $value['term_id'];
		}

		return $ids;
	}

	public function filterTaxId($taxIds)
	{
		if (empty($taxIds)) {
			$taxIds = $this->getRandomTax();
		} else {
			$filtered = [];
			$taxArr = explode(',', $taxIds);
			foreach ($taxArr as $key => $id) {
				$term = get_term($id);
				if ($term && $term->count) {
					$filtered[] = $id;
				}
			}

			$taxIds = $filtered;
		}

		return $taxIds;
	}

	public function buildTopCategoryData($taxIds = null)
	{
		$taxIds = $this->filterTaxId($taxIds);
		$productLoops = [];
		foreach ($taxIds as $key => $id) {
			$loop = $this->getProductLoopByTax($id);
			if ($loop) {
				$productLoops[$id] = $loop;
			}
		}

		return ($productLoops);
	}

	public function getProductLoopByTax ($taxId, $taxonomy = 'product_cat')
	{
		$term = get_term($taxId);
		if (!$term || !$term->count) {
			return [];
		}
		$query = new \WP_Query( $args = array(
		    'post_type'             => 'product',
		    'post_status'           => 'publish',
		    'ignore_sticky_posts'   => 1,
		    'posts_per_page'        => 10,
		    //'post__not_in'          => array( get_the_id() ), // Excluding current product
		    'tax_query'             => array( array(
		        'taxonomy'      => $taxonomy,
		        'field'         => 'term_id', // can be 'term_id', 'slug' or 'name'
		        'terms'         => $taxId,
		    ), ),
		));

		return $query;
	}

	public function buildObject($theme_location)
	{
		if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
	        $menu = get_term( $locations[$theme_location], 'nav_menu' );
	        $menu_items = wp_get_nav_menu_items($menu->term_id);

	        $results = [];
	        foreach( $menu_items as $menu_item ) {
	            if ( !$menu_item->menu_item_parent ) {
	                $parent_id = $menu_item->ID;
	                 
	                $results[$parent_id] = get_object_vars($menu_item);
	            }
	 
	            if ( $parent_id == $menu_item->menu_item_parent ) {
	                $menu_id = $menu_item->ID;
	                $results[$parent_id]['children'][$menu_id] = get_object_vars($menu_item);
	            }
	        }
	        return $this->nav_menus_get_hierarchy($menu_items);
	    }


		return [];
	}

	public function nav_menus_get_hierarchy($records){
	    $hierarchy = [];
	    $root_parent = 0;

	    /*
	        let's assume everybody is going to be a parent
	    */

	    foreach($records as $each_record){
	        $each_record = get_object_vars($each_record);
	        $each_record['children'] = [];
	        $hierarchy[$each_record['ID']] = $each_record;
	    }

	    /*
	       Now add child to parent's key in $hierarchy in the 'child' key. 
	       The & is important since there may be future childs for current child. So pass by reference is needed
	    */
	    foreach($records as $each_record){
	        $each_record = get_object_vars($each_record);
	        $hierarchy[$each_record['menu_item_parent']]['children'][] = &$hierarchy[$each_record['ID']];
	    }

	    $hasChildItems = [];

	    /* 
	        here I unset every key which wasn't at root level,i.e is 0(top) level
	    */
	    foreach($hierarchy as $parent => $its_data) {
	    	
	        if ($parent != $root_parent) {
	        	if (!empty($its_data['children'])) {
	        		$hasChildItems[] = $its_data['menu_item_parent'];
	        	}
	            unset($hierarchy[$parent]);
	        }
	    }

	    $hasChildItems = array_filter($hasChildItems);

	    $hierarchy = isset($hierarchy[$root_parent],$hierarchy[$root_parent]['children']) ? $hierarchy[$root_parent]['children'] : [];

	    foreach($hierarchy as &$its_data){
	        $id = $its_data['ID'];
	        if (in_array($id, $hasChildItems)) {
	        	$its_data['total_level'] = 3;
	        	continue;
	        }
	        $its_data['total_level'] = 2;
	    }

	    return $hierarchy;
	}
}
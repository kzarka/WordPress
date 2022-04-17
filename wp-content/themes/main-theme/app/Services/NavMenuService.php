<?php

namespace App\Services;
use App\Abc;

/**
 * Nav Menu Service
 */
class NavMenuService
{
	function __construct()
	{
		
	}

	public function init()
	{
		add_action( 'init', array( $this, 'registerMenus' ) );
	}

	public function registerMenus()
	{
		register_nav_menus(
	    	array(
	      		config('app.navbar.pc') => __( 'Header Navigator PC' ),
	            config('app.navbar.tablet') => __( 'Header Navigator Tablet' ),
	      		config('app.navbar.sp') => __( 'Header Navigator Mobile' ),
	     	)
	   	);
	}

	public function loadHeaderPCNav()
	{
		$items = $this->buildObject(config('app.navbar.pc'));
    	if(empty($items)) return false;

	    return $items;
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
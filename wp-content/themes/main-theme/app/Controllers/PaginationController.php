<?php

namespace App\Controllers;

use App\Services\NavMenuService;
/**
 * NavController
 */
class PaginationController extends BaseController
{
	function __construct()
	{
		$this->navMenuService = new NavMenuService;
		$this->registerHook();
	}

	public function registerHook()
	{
		add_action('request', array($this, 'remove_page_from_query_string'));
		add_action( 'pre_get_posts',  array($this, 'setPostPerPage')  );
		add_filter( 'paginate_links_output', array($this, 'overWritePaginator'), 10, 2 );
	}

	public function setPostPerPage($query)
	{
		if ( ( ! is_admin() ) && ( $query === $GLOBALS['wp_query'] ) && ( $query->is_search() ) ) {
			$query->set( 'posts_per_page', 1 );
		} elseif ( ( ! is_admin() ) && ( $query === $GLOBALS['wp_the_query'] ) && ( $query->is_archive() ) ) {
			$query->set( 'posts_per_page', 1 );
		}

		return $query;
	}

	public function remove_page_from_query_string($query_string) {
    	if ($query_string['name'] == 'page' && isset($query_string['page'])) {
	        unset($query_string['name']);
	        $query_string['paged'] = $query_string['page'];
	    }      
	    return $query_string;
	}

	public function overWritePaginator($r, $args)
	{
		dd($args);
	}
}


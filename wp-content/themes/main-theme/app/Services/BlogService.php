<?php

namespace App\Services;

/**
 * BlogService
 */
class BlogService
{
	public function getBlogPosts ($limit = 5)
	{
		$args = array(
		    'posts_per_page' => $limit,
		    'offset' => 0,
		    'orderby' => 'ID',
		    'order' => 'DESC',
		    'post_type' => 'post',
		    'post_status' => 'publish',
		    'suppress_filters' => true
		);
		if ($category) {
			$args['cat'] = $category;
		}

		$query = new \WP_Query( $args );

		return $query;
	}
}
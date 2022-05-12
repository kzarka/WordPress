<?php

namespace App\Services;

/**
 * BlogService
 */
class BlogService
{
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
}
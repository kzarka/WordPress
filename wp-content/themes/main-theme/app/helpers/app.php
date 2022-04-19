<?php

if (!function_exists('config')) {
    function config($path)
    {
        if (!is_string($path)) {
            return null;
        }

        $path = trim($path);
        $keys = explode('.', $path);

        $keys = array_filter($keys);

        if (empty($keys) || count($keys) == 1) return null;
        $key = trim(array_shift($keys));
        $path = get_template_directory() . '/app/config/' . $key . '.php';
        if (!file_exists($path)) {
            return null;
        }

        $config = null;
        try {
            $config = include $path;
        } catch (\Throwable $e) {
            return null;
        }

        while (count($keys)) {
            $key = trim(array_shift($keys));
            if (!isset($config[$key])) {
                return null;
            }

            if (is_array($config[$key]) && count($keys) != 0) {
                $config = $config[$key];
            }

            if (count($keys) == 0) return $config[$key];
        }

        return null;
    }
}

if (!function_exists('getViewArgs')) {
    function getViewArgs($args, $key)
    {
        if (!empty($args[$key])) {
        	return $args[$key];
        }

        return null;
    }
}

if (!function_exists('dd')) {
    function dd($var)
    {
    	print_r($var);
    	die;
    }
}

if (!function_exists('dd')) {
    function dd($var)
    {
        print_r($var);
        die;
    }
}

if (!function_exists('renderTemplate')) {
    function renderTemplate($path, $args = [])
    {
        if (!is_array($args) && !empty($args)) {
            $args = [$args];
        }

        $fullPath = get_template_directory() . config('app.view_path') . $path . '.php';
        $template_path = config('app.view_path') . $path;
        if (!file_exists($fullPath)) {
            echo "Template not found " . $path;
            new \WP_Error( 'broke', __( "I've fallen and can't get up", "my_textdomain" ) );
            die;
        }

        get_template_part($template_path, null, $args);
    }
}

if (!function_exists('post_pagination')) {
    function post_pagination() {
        if( is_singular() )
        return;

        global $wp_query;

        /** Stop execution if there's only 1 page */
        if( $wp_query->max_num_pages <= 1 )
            return;

        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $wp_query->max_num_pages );

        /** Add current page to the array */
        if ( $paged >= 1 )
            $links[] = $paged;

        /** Add the pages around the current page to the array */
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if ( ( $paged + 2 ) <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        $html = '';

        $html .= '<div class="pages ajax_pagination"><ul class="pagination">';

        /** Previous Post Link */
        if ( get_previous_posts_link() )
            $html .= sprintf( '<li><a href="%s"> < </a></li>', get_previous_posts_page_link() );

        /** Link to first page, plus ellipses if necessary */
        if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? ' class="active"' : '';

            if ($class) {
                $html .= sprintf( '<li%s><span>%s</span></li>', $class, '1' );
            } else {
                $html .= sprintf( '<li%s><a href="%s"><span>%s</span></a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );

            }

            if ( ! in_array( 2, $links ) )
                $html .= '<li>…</li>';
        }

        /** Link to current page, plus 2 pages in either direction if necessary */
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = $paged == $link ? ' class="active"' : '';
            if ($class) {
                $html .= sprintf( '<li%s><span>%s</span></li>', $class, $link );
            } else {
                $html .= sprintf( '<li%s><a href="%s"><span>%s</span></a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );

            }
        }

        /** Link to last page, plus ellipses if necessary */
        if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) )
                $html .= '<li>…</li>' . "\n";

            $class = $paged == $max ? ' class="active"' : '';
            $html .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $max ) ), $max );
        }

        /** Next Post Link */
        if ( get_next_posts_link() )
            $html .= sprintf( '<li><a href="%s"> > </a></li>', get_next_posts_page_link() );

        $html .= '</ul></div>' . "\n";
        echo $html;
    }
}
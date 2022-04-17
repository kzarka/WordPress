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
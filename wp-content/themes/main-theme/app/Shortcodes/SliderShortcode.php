<?php

namespace App\Shortcodes;

/**
 * SliderShortcode
 */
class SliderShortcode
{
    function __construct()
    {
        add_shortcode('slider', array( $this, 'main' ));
    }

    public function main($atts)
    {
    	$original = $data = get_soliloquy_slider($atts);
    	if (empty($data) && empty($data['slider'])) {
    		$data = [];
    	} else {
    		$data = $data['slider'];
    	}

        return renderTemplateHTML('header/slider', ['data' => $data, 'original' => $original]);
    }
}



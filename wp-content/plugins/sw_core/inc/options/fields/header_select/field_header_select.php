<?php
class SW_Options_header_select extends SW_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since SW_Options 1.0.1
	*/
	function __construct($field = array(), $value ='', $parent = null){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		
		
	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since SW_Options 1.0.1
	*/
	function render(){
		
		$class = (isset($this->field['class']))?'class="'.esc_attr( $this->field['class'] ).'" ':'';
		
		echo '<select id="'.esc_attr( $this->field['id'] ).'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" '.$class.'>';
		echo '<option value="" selected>'.esc_html__( 'Select Header', 'sw_core' ).'</option>';
		
		$headers = new WP_Query( array(
			'post_type' => 'elementor_library', 
			'orderby' => 'name', 
			'order' => 'ASC', 
			'meta_key' => '_elementor_template_type', 
			'meta_value' => 'header', 
			'showposts' => -1 
		));
		if( $headers->have_posts() ){
			foreach ( $headers->posts as $item ) {
				echo '<option value="'.esc_attr( $item->ID ).'"'.selected($this->value, $item->ID, false).'>'.esc_html( $item->post_title ).'</option>';
			}
		}

		echo '</select>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.esc_html( $this->field['desc'] ).'</span>':'';
		
	}//function
	
	public function getCpanelHtml(){
		echo ' <div class="control-group">';
		echo '<label class="control-label">'.esc_html( $this->field['title'] ).'</label>';
		echo '<div class="controls">';
		$this->render();
		echo '</div></div>';
	}
}//class
?>
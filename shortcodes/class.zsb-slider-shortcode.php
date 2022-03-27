<?php

if( !class_exists( 'ZSB_Slider_Sortcode' ) ){
	class ZSB_Slider_Shortcode {
		public function __construct(){
			add_shortcode( 'zsb_slider', array( $this, 'add_shortcode' ) );
		}

		public function add_shortcode( $atts = array(), $content = null, $tag = '' ){
			$atts = array_change_key_case( (array) $atts, CASE_LOWER );

			extract( shortcode_atts(
				array(
					'id'	=> '',
					'orderby'	=> 'date',
				),
				$atts,
				$tag,
			) );

			if( !empty($id) ){
				$id = array_map( 'absint', explode( ',', $id ) );
			}

			ob_start();
			require( ZSB_SLIDER_PATH . 'views/zsb-slider_shortcode.php' );
			wp_enqueue_style( 'zsb-slider-main-css' );
			zsb_slider_options();
			return ob_get_clean();
		}
	}
}
<?php

if( !function_exists( 'zsb_slider_get_placeholder_image' ) ){
	function zsb_slider_get_placeholder_image(){
		return "<img src='". ZSB_SLIDER_URL . "images/default.jpg' class='img-fluid wp-post-image' >";
	}
}

if( !function_exists( 'zsb_slider_options' ) ){
	function zsb_slider_options(){
		$show_bullets = isset( ZSB_Slider_Settings::$options['zsb_slider_bullets'] ) && ZSB_Slider_Settings::$options['zsb_slider_bullets'] == 1 ? true : false;

		wp_enqueue_script( 'zsb-slider-main-js', ZSB_SLIDER_URL . 'assets/index.js', array(), ZSB_SLIDER_VERSION, true );
		wp_localize_script( 'zsb-slider-main-js', 'SLIDER_OPTIONS', array(
			'controlNav' => $show_bullets,
		) );
	}
}
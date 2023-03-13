<?php

/**
	* Plugin Name: ZSB Slider
	* Plugin URI: https://zsoltbogdan.hu/plugins/zsb-slider
	* Description: My plugin's description
	* Version: 1.0
	* Requirest at least: 5.6
	* Author: Zsolt Bogdán
	* Author URI: https://zsoltbogdan.hu
	* License: GPL v3 or later
	* License URI: https://www.gnu.org/licenses/gpl-3.0.html
	* Text Domain: zsb-slider
	* Domain Path: ./languages
 */

	if( !defined( 'ABSPATH' ) ){
		exit;
	}

	if( !class_exists( 'ZSB_Slider' ) ){
		class ZSB_Slider {
			function __construct(){
				$this->define_constants();

				$this->load_textdomain();

				require_once( ZSB_SLIDER_PATH . 'functions/functions.php' );

				add_action( 'admin_menu', array( $this, 'add_menu' ) );

				require_once( ZSB_SLIDER_PATH . 'post-types/class.zsb-slider-cpt.php');
				$ZSB_Slider_Post_Type = new ZSB_Slider_Post_Type();

				require_once( ZSB_SLIDER_PATH . 'class.zsb-slider-settings.php' );
				$ZSB_Slider_Settings = new ZSB_Slider_Settings();

				require_once( ZSB_SLIDER_PATH . 'shortcodes/class.zsb-slider-shortcode.php');
				$ZSB_Slider_Shortcode = new ZSB_Slider_Shortcode();

				add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999  );
				add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
			}

			public function define_constants(){
				define( 'ZSB_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
				define( 'ZSB_SLIDER_URL', plugin_dir_url( __FILE__ ) );
				define( 'ZSB_SLIDER_VERSION', '1.0.0' );
			}

			public static function activate(){
				update_option( 'rewrite_rules', '' );
			}

			public static function deactivate(){
				flush_rewrite_rules();
				unregister_post_type( 'zsb-slider' );
			}

			public static function uninstall(){
				delete_option( 'zsb_slider_options' );

				$posts = get_posts(
					array(
						'post_type'	=> 'zsb-slider',
						'number_posts'	=> -1,
						'post_status'	=> 'any',
					)
				);

				foreach( $posts as $post ){
					wp_delete_post( $post->ID, true );
				}
			}

			public function load_textdomain(){
				load_plugin_textdomain(
					'zsb-slider',
					false,
					dirname( plugin_basename( __FILE__ ) ) . '/languages/'
				);
			}

			public function add_menu(){
				add_menu_page(
					esc_html__( 'ZSB Slider Options', 'zsb-slider' ),
					esc_html__( 'ZSB Slider', 'zsb-slider' ),
					'manage_options',
					'zsb_slider_admin',
					array( $this, 'zsb_slider_settings_page'),
					'dashicons-images-alt2',
				);

				add_submenu_page(
					'zsb_slider_admin',
					esc_html__( 'Manage Slides', 'zsb-slider' ),
					esc_html__( 'Manage Slides', 'zsb-slider' ),
					'manage_options',
					'edit.php?post_type=zsb-slider',
					null,
					null,
				);

				add_submenu_page(
					'zsb_slider_admin',
					esc_html__( 'Add New Slide', 'zsb-slider' ),
					esc_html__( 'Add New Slide', 'zsb-slider' ),
					'manage_options',
					'post-new.php?post_type=zsb-slider',
					null,
					null,
				);
			}

			public function zsb_slider_settings_page(){
				if( !current_user_can( 'manage_options' ) ){
					return;
				}
				if( isset( $_GET['settings-updated'] ) ){
					add_settings_error( 'zsb_slider_options', 'zsb_slider_message', esc_html__( 'Settings Saved', 'zsb-slider' ), 'success' );
				}
				settings_errors( 'zsb_slider_options' );
				require( ZSB_SLIDER_PATH . 'views/settings-page.php');
			}

			public function register_scripts(){
				wp_register_style( 'zsb-slider-main-css', ZSB_SLIDER_URL . 'build/index.css', array(), ZSB_SLIDER_VERSION, 'all');
			}

			public function register_admin_scripts(){
				global $typenow;
				if( $typenow == 'zsb-slider' ){
					wp_enqueue_style( 'zsb-slider-admin', ZSB_SLIDER_URL . 'build/style-index.css', array(), ZSB_SLIDER_VERSION, 'all');
				}
			}
		}
	}

	if( class_exists( 'ZSB_Slider' ) ){
		register_activation_hook( __FILE__, array( 'ZSB_Slider', 'activate' ) );
		register_deactivation_hook( __FILE__, array( 'ZSB_Slider', 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( 'ZSB_Slider', 'uninstall' ) );
		$zsb_slider = new ZSB_Slider();
	}
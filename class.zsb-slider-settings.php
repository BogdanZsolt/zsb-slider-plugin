<?php

if( !class_exists( 'ZSB_Slider_Settings' ) ){
	class ZSB_Slider_Settings {
		public static $options;

		public function __construct(){
			self::$options = get_option( 'zsb_slider_options' );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		public function admin_init(){

			register_setting( 'zsb_slider_group', 'zsb_slider_options', array( $this, 'zsb_slider_validate' ) );

			add_settings_section(
				'zsb_slider_main_section',
				esc_html__( 'How does it work?', 'zsb-slider' ),
				null,
				'zsb_slider_page1',
			);

			add_settings_section(
				'zsb_slider_second_section',
				esc_html__( 'Other Plugin Options', 'zsb-slider' ),
				null,
				'zsb_slider_page2',
			);

			add_settings_field(
				'zsb_slider_shortcode',
				esc_html__( 'Shortcode', 'zsb-slider' ),
				array( $this, 'zsb_slider_shortcode_callback' ),
				'zsb_slider_page1',
				'zsb_slider_main_section',
			);

			add_settings_field(
				'zsb_slider_title',
				esc_html__( 'Slider Title', 'zsb-slider' ),
				array( $this, 'zsb_slider_title_callback' ),
				'zsb_slider_page2',
				'zsb_slider_second_section',
			);

			add_settings_field(
				'zsb_slider_bullets',
				esc_html__( 'Display Bullets', 'zsb-slider' ),
				array( $this, 'zsb_slider_bullets_callback' ),
				'zsb_slider_page2',
				'zsb_slider_second_section',
				array(
					'label_for' => 'zsb_slider_bullets',
				)
			);

			add_settings_field(
				'zsb_slider_style',
				esc_html__( 'Slider Style', 'zsb-slider' ),
				array( $this, 'zsb_slider_style_callback' ),
				'zsb_slider_page2',
				'zsb_slider_second_section',
				array(
					'items'	=> array(
							'style-1',
							'style-2',
							'lasaphire',
					),
					'label_for'	=> 'zsb_slider_style',
				)
			);
		}

		public function zsb_slider_shortcode_callback(){
			?>
			<span><?php esc_html_e( 'Use the shortcode [zsb_slider] to display the slider in any page/post/widget', 'zsb-slider' ) ?></span>
			<?php
		}

		public function zsb_slider_title_callback( $args ){
			?>
			<input
				type="text"
				name="zsb_slider_options[zsb_slider_title]"
				id="zsb_slider_title"
				value="<?php echo isset( self::$options['zsb_slider_title'] ) ? esc_attr( self::$options['zsb_slider_title'] ) : ''; ?>"
			>
			<?php
		}

		public function zsb_slider_bullets_callback( $args ){
			?>
			<input
				type="checkbox"
				name="zsb_slider_options[zsb_slider_bullets]"
				id="zsb_slider_bullets"
				value="1"
				<?php
					if( isset( self::$options['zsb_slider_bullets'] ) ){
						checked( "1", self::$options['zsb_slider_bullets'], true );
					}
				?>
			>
			<label for="zsb_slider_bullets"><?php esc_html_e('Whether to display bullets or not', 'zsb-slider' ); ?></label>
			<?php
		}

		public function zsb_slider_style_callback( $args ){
			?>
			<select
				id="zsb_slider_style"
				name="zsb_slider_options[zsb_slider_style]"
				<?php
				foreach( $args['items'] as $item ):
				?>
			>
				<option value="<?php echo esc_attr( $item ); ?>"
					<?php isset( self::$options['zsb_slider_style'] ) ? selected( $item, self::$options['zsb_slider_style'], true ) : ''; ?>
				>
				<?php echo esc_html( ucfirst( $item )); ?>
				</option>
				<?php endforeach; ?>
			</select>
			<?php
		}

		public function zsb_slider_validate( $input ){
			$new_input = array();
			foreach( $input as $key => $value ){
				switch($key){
					case 'zsb_slider_title':
						if( empty( $value) ){
							add_settings_error( 'zsb_slider_options', 'zsb_slider_message', esc_html__( 'The title field can not be left empty', 'zsb-slider' ), 'error' );
							$value = esc_html__( 'Please, type some text', 'zsb-slider' );
						}
						$new_input[$key] = sanitize_text_field( $value );
					break;
					default:
						$new_input[$key] = sanitize_text_field( $value );
					break;
				}
			}
			return $new_input;
		}

	}
}
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'main_options'; ?>
	<h2 class="nav-tab-wrapper">
		<a aria-label="<?php esc_attr_e( 'Toggle navigation', 'zsb-slider' ); ?>" href="?page=zsb_slider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Main Options', 'zsb-slider' ); ?></a>
		<a href="?page=zsb_slider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Additional Options', 'zsb-slider' ); ?></a>
	</h2>
	<form action="options.php" method="post">
		<?php
			if( $active_tab == 'main_options'){
				settings_fields( 'zsb_slider_group' );
				do_settings_sections( 'zsb_slider_page1' );
			} else {
				settings_fields( 'zsb_slider_group' );
				do_settings_sections( 'zsb_slider_page2' );
			}
			submit_button( esc_html__( 'Save Settings', 'zsb-slider' ) );
		?>
	</form>
</div>
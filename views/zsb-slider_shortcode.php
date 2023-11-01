<div
  class="zsb-slider <?php echo ( isset(ZSB_Slider_Settings::$options['zsb_slider_style'] ) ) ? esc_attr( ZSB_Slider_Settings::$options['zsb_slider_style'] ) : 'style-1'; ?>">
  <ul class="slides">
    <?php
			$args = array(
				'post_type'	=> 'zsb-slider',
				'post_status'	=> 'publish',
				'post__in'	=> $id,
				'orderby'	=> $orderby,
			);

			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ):
				while( $my_query->have_posts() ) : $my_query->the_post();

				$button_text = get_post_meta( get_the_ID(), 'zsb_slider_link_text', true );
				$button_url = get_post_meta( get_the_ID(), 'zsb_slider_link_url', true );
		?>
    <li class="slide">
      <?php
				if( has_post_thumbnail() ){
					the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
					the_post_thumbnail( 'la-saphire-featured-portrait', array( 'class' => 'img-mobile' ) );
				} else {
					echo zsb_slider_get_placeholder_image();
				}
				?>
      <div class="zsbs-container">
        <div class="slider-details-container">
          <div class="wrapper">
            <div class="slider-title">
              <h1><?php the_title(); ?></h1>
            </div>
            <div class="slider-description">
              <div class="subtitle"><?php the_content(); ?></div>
              <a class="link" href="<?php echo esc_attr( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
            </div>
          </div>
        </div>
      </div>
    </li>
    <?php
			endwhile;
			wp_reset_postdata();
			endif;
		?>
  </ul>
</div>
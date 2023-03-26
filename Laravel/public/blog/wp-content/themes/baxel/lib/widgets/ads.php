<?php

class baxel_widget_ads extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_ads', esc_html__( '11. Baxel Widget: Ads', 'baxel' ), array( 'description' => esc_html__( "You can place your Ad code into this widget.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		?>
        
		<p><textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>
        
		<?php
		
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		if ( current_user_can( 'unfiltered_html' ) ) {
			
			$instance['text'] = $new_instance['text'];
			
		} else {
			
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
			
		}
				
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
		
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		?>
		
        <div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>baxel_widget_ads clearfix"><?php echo apply_filters( 'widget_text', $instance['text'] ); ?></div>
        
		<?php
		
	}
	
	function defaults() {
		
		$defaults = array( 'text' => '' );		
		return $defaults;
		
	}
	
}
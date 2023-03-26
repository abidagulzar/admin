<?php

class baxel_widget_empty_space extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_empty_space', esc_html__( '12. Baxel Widget: Empty Space', 'baxel' ), array( 'description' => esc_html__( "An extra empty space between your widgets.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	
		?>
		
        <p><?php echo esc_html__( 'Height:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
		
		<?php
	
	}
		
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 40;
		
		return $instance;	
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
						
		$count = apply_filters( 'widget_title', $instance['count'] );	
		
		?>
            
		<div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>baxel_widget_empty_space" style="height: <?php echo esc_attr( $count ); ?>px;"></div>
            
        <?php 
	
	}
	
	function defaults() {
		
		$defaults = array( 'count' => 40 );		
		return $defaults;
		
	}

}

?>
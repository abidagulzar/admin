<?php

class baxel_widget_image extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_image', esc_html__( '06. Baxel Widget: Image', 'baxel' ), array( 'description' => esc_html__( "Display an image with an optional title.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	
		?>
		
        <p><?php echo esc_html__( 'Image Path:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'path' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['path'] ); ?>" class="widefat" /></p>
        <p>
        <em><?php echo esc_html__( 'To find the image path, go to "Media > Library", click the image and see the "URL" field.', 'baxel' ); ?></em>
        </p>
        <p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Link:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" class="widefat" /></p>
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['target'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Open in new window', 'baxel' ); ?></label>
		</p>
		
		<?php
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
						
	    $instance['name'] = $new_instance['name'];
		$instance['path'] = $new_instance['path'];
		$instance['link'] = $new_instance['link'];
		$instance['target'] = !empty( $new_instance['target'] );
		
		return $instance;	
		
	}
		
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
								
		$name = apply_filters( 'widget_title', $instance['name'] );
		$path = $instance['path'];
		$link = $instance['link'];
		$target = $instance['target'];
				
		$iw_rand = rand( 1, 9999999 );
		
		?>
        
        <div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>baxel_widget_image <?php echo esc_attr( 'iw-' . $iw_rand ); ?>">		
            <div class="image-widget-wrapper clearfix"><?php if ( $link ) { echo '<a href="' . esc_attr( $link ) . '" target="'; if ( $target ) { echo '_blank'; } else { echo '_self'; } echo '">'; } ?>
            <?php if ( $name ) { ?><div class="image-widget-title fading"><?php echo esc_attr( $name ); ?></div><?php } ?>
			<?php if ( $path ) { ?><img alt="" src="<?php echo esc_attr( $path ); ?>" /><?php } ?>
            <?php if ( $link ) { echo '</a>'; } ?></div>        
        </div>
					
		<?php 
	
	}
	
	function defaults() {
		
		$defaults = array( 'name' => esc_html__( 'ABOUT ME', 'baxel' ), 'path' => '', 'link' => '', 'target' => 0 );		
		return $defaults;
		
	}

}

?>
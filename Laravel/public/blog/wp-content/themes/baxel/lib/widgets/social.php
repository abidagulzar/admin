<?php

class baxel_widget_social extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_social', esc_html__( '08. Baxel Widget: Social', 'baxel' ), array( 'description' => esc_html__( "Show your social account icons.", 'baxel' ), 'classname' => 'baxel_widget_social' ) );
		
	}
	
	function form( $instance ) {
		
		$account_names = baxel_social_names();
		$defaults = array( 'name' => esc_html__( 'SOCIAL', 'baxel' ) );						
		foreach ( $account_names as $key ) { $defaults[ $key ] = 'http://'; }		
		$instance = wp_parse_args( ( array ) $instance, $defaults );
					        		
		?>
        
		<p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><em><?php echo esc_html__( 'Write the entire URL addresses. Leave blank if not preferred.', 'baxel' ); ?></em></p>
        
        <?php
				
		foreach ( baxel_social_labels() as $key => $lbl ) {
	
			echo '<p>' . $lbl . ': <input name="' . esc_attr( $this->get_field_name( $account_names[ $key ] ) ) . '" type="text" value="' . esc_attr( $instance[ $account_names[ $key ] ] ) . '" class="widefat" /></p>';
			
		}
	
	}
		
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
				
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'SOCIAL', 'baxel' );
		
		foreach ( baxel_social_names() as $key ) {
			
			$instance[ $key ] = $new_instance[ $key ] ? strip_tags( $new_instance[ $key ] ) : 'http://';
				
		}
						
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$defaults = array( 'name' => esc_html__( 'Social', 'baxel' ) );
		foreach ( baxel_social_names() as $key ) { $defaults[ $key ] = 'http://'; }		
		$instance = wp_parse_args( ( array ) $instance, $defaults );
		
		echo wp_kses_post( $before_widget );
		
		$icons = baxel_social_icons();
		$social_accounts = array();
				
		$name = apply_filters( 'widget_title', $instance['name'] );
		
		foreach ( baxel_social_names() as $key ) {
			
			$$key = $instance[ $key ];
			array_push( $social_accounts, $$key );
				
		}
					
		$sw_rand = rand( 1, 9999999 );  ?>
        
        <?php
						
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
			
		echo '<ul class="clearfix ' . esc_attr( 'sw-' . $sw_rand ) . '">';
						
		foreach ( $social_accounts as $key => $sa ) {
	
			if ( $sa != 'http://' && $sa != '' ) {
					
				echo '<li><a href="' . esc_url( $sa ) . '" target="_blank"><i class="fa ' . $icons[ $key ] . '"></i></a></li>';
						
			}
			
		}
			
		echo '</ul>';
		
		echo wp_kses_post( $after_widget );
	
	}

}

?>
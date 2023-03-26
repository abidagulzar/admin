<?php

class baxel_widget_search extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_search', esc_html__( '10. Baxel Widget: Search', 'baxel' ), array( 'description' => esc_html__( "A search form for your site.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	        		
		?>
        
        <script type='text/javascript'>
		
            jQuery( document ).ready( function($) {
				
                $('.sew-bg-color-picker').wpColorPicker( {

		            defaultColor: '#FFF',
					change: _.throttle( function() { $('.sew-bg-color-picker').trigger( 'change' ) }, 3000 ),
					
				} );
				
				$('.sew-t-color-picker').wpColorPicker( {

		            defaultColor: '#333',
					change: _.throttle( function() { $('.sew-t-color-picker').trigger( 'change' ) }, 3000 ),
					
				} );
				
            } );
			
        </script>
        
        <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"><?php echo esc_html__( 'Background Color:', 'baxel' ); ?></label>
		<br />
		<input class="sew-bg-color-picker" type="text" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" value="<?php echo esc_attr( $instance['background_color'] ); ?>" />                            
        </p>        
        <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>"><?php echo esc_html__( 'Text Color:', 'baxel' ); ?></label>
		<br />
		<input class="sew-t-color-picker" type="text" id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>" value="<?php echo esc_attr( $instance['text_color'] ); ?>" />                            
        </p>
        		
		<?php
	
	}
		
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['text_color'] = $new_instance['text_color'];
		$instance['background_color'] = $new_instance['background_color'];
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
				
		$text_color = $instance['text_color'];
		$background_color = $instance['background_color'];
		
		?>
		
        <div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>clearfix baxel_widget_search" style="background-color: <?php echo esc_attr( $background_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>;">
            <form class="search-widget-form" role="search" method="get" id="swf-id" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input class="search-widget-input" type="text" value="<?php echo esc_attr( baxel_translation( '_Keyword' ) ); ?>" name="s" id="swi-id" style="background-color: <?php echo esc_attr( $background_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>;" />
            </form>
            <div class="search-widget-icon fading"><i class="fa fa-search"></i></div>
        </div>
        
        <?php
	
	}
	
	function defaults() {
		
		$defaults = array( 'text_color' => '#333', 'background_color' => '#FFF' );		
		return $defaults;
		
	}

}

?>
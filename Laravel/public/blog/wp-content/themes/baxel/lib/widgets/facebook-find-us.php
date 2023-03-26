<?php

class baxel_widget_facebook extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_facebook', esc_html__( '09. Baxel Widget: Find Us on Facebook', 'baxel' ), array( 'description' => esc_html__( "Show your Facebook page's lovers.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	
		?>
		
		<p><?php echo esc_html__( 'Facebook Page Username:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'page' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['page'] ); ?>" class="widefat" /></p>
        <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php echo esc_html__( 'Height (min. 130):', 'baxel' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['height'] ); ?>" style="width: 55px;" />
		</p>        
        <p>
        <input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['faces'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'faces' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'faces' ) ); ?>"><?php echo esc_html__( "Show Friend's Faces ('Height' value must be at least 215.)", 'baxel' ); ?></label>
		</p>        
        <p>
        <input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['posts'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>"><?php echo esc_html__( "Show Page Posts ('Height' value must be at least 300.)", 'baxel' ); ?></label>
		</p>
		
		<?php
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
				
		$instance['page'] = $new_instance['page'] ? strip_tags( $new_instance['page'] ) : 'burnhambox';
		$instance['height'] = $new_instance['height'] ? strip_tags( $new_instance['height'] ) : 400;
		$instance['faces'] = !empty( $new_instance['faces'] );
		$instance['posts'] = !empty( $new_instance['posts'] );
		
		return $instance;	
		
	}
	
	function widget( $args, $instance ) {
			
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
														
		$page = apply_filters( 'widget_title', $instance['page'] );
		$height = $instance['height'];
		$faces = $instance['faces'];
		$posts = $instance['posts'];
		
		?>
			
        <div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>baxel_widget_facebook">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              <?php $facebook_sdk_language = get_bloginfo( 'language' ); ?>
              js.src = "//connect.facebook.net/" + "<?php echo str_replace( '-', '_', $facebook_sdk_language ); ?>" + "/sdk.js#xfbml=1&version=v2.4";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            
            <div class="fb-page" data-href="https://www.facebook.com/<?php echo esc_attr( $page ); ?>" data-width="300" data-height="<?php echo esc_attr( $height ); ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="<?php if ( $faces ) { echo 'true'; } else { echo 'false'; } ?>" data-show-posts="<?php if ( $posts ) { echo 'true'; } else { echo 'false'; } ?>"><div class="fb-xfbml-parse-ignore"></div></div>
        </div>
                                                
        <?php 
			
	}
	
	function defaults() {
		
		$defaults = array( 'page' => 'burnhambox', 'height' => 400, 'faces' => 1, 'posts' => 1 );		
		return $defaults;
		
	}

}

?>
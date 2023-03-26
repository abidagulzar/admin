<?php

class baxel_widget_post extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_post', esc_html__( '05. Baxel Widget: Post', 'baxel' ), array( 'description' => esc_html__( "Display a single post.", 'baxel' ) ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		global $post;
		$posts = get_posts( array( 'numberposts' => -1 ) );
				
		?>

        <p><?php echo esc_html__( 'Original Post:', 'baxel' ); ?>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>">
        	<option <?php echo esc_attr( $instance['post_id'] ) == 0 ? 'selected="selected"' : '';?> value="0"><?php echo esc_html__( '- Select a Post -', 'baxel' ); ?></option>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
        	<option <?php if ( $post->ID == esc_attr( $instance['post_id'] ) ) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr( $post->ID ); ?>"><?php the_title(); ?></option>
			<?php endforeach; ?>
		</select>
		</p>        
        <p><?php echo esc_html__( 'Alternative Post:', 'baxel' ); ?>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_name( 'post_id_alt' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'post_id_alt' ) ); ?>">
        	<option <?php echo esc_attr( $instance['post_id_alt'] ) == 0 ? 'selected="selected"' : '';?> value="0"><?php echo esc_html__( '- Select an Alternative Post -', 'baxel' ); ?></option>
			<?php foreach( $posts as $post ) : setup_postdata( $post ); ?>
        	<option <?php if ( $post->ID == esc_attr( $instance['post_id_alt'] ) ) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr( $post->ID ); ?>"><?php the_title(); ?></option>
			<?php endforeach; ?>
		</select>
		</p>        
        <p>
        <em><?php echo esc_html__( 'To avoid duplicated posts, you can set an alternative post which will be shown instead of the original one, on the original post page. Or simply hide this widget on the original post page by checking the box below.', 'baxel' ); ?></em>
        </p>                       		
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['hide_widget'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_widget' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_widget' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'hide_widget' ) ); ?>"><?php echo esc_html__( 'Hide this widget on the original post page', 'baxel' ); ?></label>
		</p>                		        
        <p>
		<input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['target'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Open in new window', 'baxel' ); ?></label>
		</p>        
        <p>
        <input class="checkbox" type="checkbox" value="1" <?php esc_attr( checked( $instance['date'], 1 ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" /> 
		<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php echo esc_html__( 'Display post date', 'baxel' ); ?></label>
		</p>
		
		<?php
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['date'] = !empty( $new_instance['date'] );
		$instance['post_id'] = $new_instance['post_id'];
		$instance['post_id_alt'] = $new_instance['post_id_alt'];
		$instance['hide_widget'] = !empty( $new_instance['hide_widget'] );
		$instance['target'] = !empty( $new_instance['target'] );
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
								
		$date = $instance['date'];
		$post_id = $instance['post_id'];
		$post_id_alt = $instance['post_id_alt'];
		$hide_widget = $instance['hide_widget'];
		$target = $instance['target'];
		
		$pw_rand = rand( 1, 9999999 );

		if ( $post_id != 0 && ( get_the_ID() != $post_id || ( get_the_ID() == $post_id && !$hide_widget ) ) ) {

			if ( get_the_ID() == $post_id && $post_id_alt != 0 ) { $post_id = $post_id_alt; }
																
			$widget_query = new WP_Query( array( 'p' => $post_id ) );
	
			while ( $widget_query->have_posts() ) : $widget_query->the_post(); ?>
				
                <div id="<?php echo esc_attr( $this->id ); ?>" class="<?php baxel_footer_widgets_outer( $id ); ?>baxel_widget_post <?php echo esc_attr( 'pw-' . $pw_rand ); ?>">
					<?php echo '<a class="clearfix" href="' . get_the_permalink() . '" target="'; if ( $target ) { echo '_blank'; } else { echo '_self'; } echo '">'; ?>				
                    <?php the_post_thumbnail( 'baxel-thumbnail-image' ); ?>						
                    <div class="post-widget-container fading<?php if ( !has_post_thumbnail() ) { echo ' pwc-woi'; } ?>">
                        <?php if ( $date ) { ?><div class="post-widget-date"><?php echo get_the_date(); ?></div><?php } ?>
                        <div class="post-widget-title"><?php the_title(); ?></div>
                    </div>
                    </a>
                </div>
				   
			<?php endwhile;
				
			wp_reset_postdata();
						
		}
	
	}
	
	function defaults() {
		
		$defaults = array( 'date' => 1, 'post_id' => 0, 'post_id_alt' => 0, 'hide_widget' => 0, 'target' => 0 );		
		return $defaults;
		
	}

}

?>
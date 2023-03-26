<?php

class baxel_widget_recent_posts extends WP_Widget {
	
	function __construct() {
		
		parent::__construct( 'baxel_widget_recent_posts', esc_html__( '01. Baxel Widget: Recent/Random Posts', 'baxel' ), array( 'description' => esc_html__( "Display the most recent or random posts.", 'baxel' ), 'classname' => 'baxel_widget_recent_posts' ) );
		
	}
	
	function form( $instance ) {
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
	
		?>
        		
		<p><?php echo esc_html__( 'Title:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['name'] ); ?>" class="widefat" /></p>
        <p><?php echo esc_html__( 'Number of posts to show:', 'baxel' ); ?> <input name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" style="width: 50px;" /></p>
        <p><?php echo esc_html__( 'Display Options:', 'baxel' ); ?></p>
        <p>
        <input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'recent' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="recent" <?php esc_attr( checked( $instance['list_type'], 'recent' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'recent' ) ); ?>"><?php echo esc_html__( 'Show Recent Posts', 'baxel' ); ?></label>
        </p>        
        <p><input class="radio" id="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_type' ) ); ?>" type="radio" value="random" <?php esc_attr( checked( $instance['list_type'], 'random' ) ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'random' ) ); ?>"><?php echo esc_html__( 'Show Random Posts', 'baxel' ); ?></label>
        </p>
		
		<?php
	
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['name'] = $new_instance['name'] ? strip_tags( $new_instance['name'] ) : esc_html__( 'RECENT POSTS', 'baxel' );
		$instance['count'] = $new_instance['count'] ? strip_tags( $new_instance['count'] ) : 5;
		$instance['list_type'] = $new_instance['list_type'];
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		extract( $args );
		
		$instance = wp_parse_args( ( array ) $instance, $this->defaults() );
		
		echo wp_kses_post( $before_widget );
				
		$name = apply_filters( 'widget_title', $instance['name'] );
		$count = $instance['count'];
		$list_type = $instance['list_type'];
		
		$rpw_rand = rand( 1, 9999999 );
		
		echo wp_kses_post( $before_title ) . esc_attr( $name ) . wp_kses_post( $after_title );
			
		if ( $list_type == 'recent' ) {
			
			$loop_args = array(
				
				'showposts' => esc_attr( $count ),
				'ignore_sticky_posts' => 1
					
			);
			
		} else {
			
			$loop_args = array(
				
				'showposts' => esc_attr( $count ),
				'orderby' => 'rand',
				'ignore_sticky_posts' => 1
					
			);
			
		}
			
		$widget_query = new WP_Query( $loop_args );

		while ( $widget_query->have_posts() ) : $widget_query->the_post();
						
		?>
            
            <a class="posts-widget-wrapper clearfix <?php echo esc_attr( 'rpw-' . $rpw_rand ); ?>" href="<?php echo get_the_permalink(); ?>">
				<?php echo the_post_thumbnail( 'baxel-small-thumbnail-image' ); ?>    
				<div class="posts-widget-container <?php if ( has_post_thumbnail() ) { echo 'posts-widget-container-with-t'; } ?>">
					<div class="table-cell-middle"><?php if ( get_theme_mod( 'baxel_show_widget_date', 0 ) ) { ?><div class="posts-widget-date"><?php echo get_the_date(); ?></div><?php } ?><div class="posts-widget-title"><?php echo get_the_title(); ?></div></div>
				</div>
			</a>
			
		<?php endwhile;
			
		wp_reset_postdata();
		
		echo wp_kses_post( $after_widget );
	
	}
	
	function defaults() {
		
		$defaults = array( 'name' => esc_html__( 'RECENT POSTS', 'baxel' ), 'count' => 5, 'list_type' => 'recent' );		
		return $defaults;
		
	}

}

?>